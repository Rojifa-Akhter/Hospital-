@extends('iCure-Home.patient.partials.patient_master')

@section('patient_content')

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
$email = isset($pat_details->email) ? $pat_details->email : '';

@endphp

<form id="msform" method="post" action="{{ route('cover.appointment-store') }}">
    {{-- <form id="msform" method="post" action="{{ route('pay') }}"> comment by Nazmul--}}

        @csrf

        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <div class="section_title_area about_us_section">
                    <h3 class="section_title2">Make Your Appointment</h3>
                </div>
            </div>
        </div>

        <fieldset>
            <input type="hidden" class="keep_me" id="hdn_appointment_date" name="hdn_appointment_date"
            value="{{ !empty($doc_data[0]->schedule_dt) ? $doc_data[0]->schedule_dt : '' }}">
            <input type="hidden" class="keep_me" id="hdn_doctor_id" name="hdn_doctor_id"
            value="{{ !empty($doc_data[0]->person_no_pk) ? $doc_data[0]->person_no_pk : '' }}">
            <input type="hidden" class="keep_me" id="hdn_hospital_id" name="hdn_hospital_id"
            value="{{ !empty($doc_data[0]->au_entry_hospital_pk_no) ? $doc_data[0]->au_entry_hospital_pk_no : '' }}">
            <input type="hidden" class="keep_me" id="hdn_service_unit" name="hdn_service_unit"
            value="{{ !empty($doc_data[0]->serviceunit_no_fk) ? $doc_data[0]->serviceunit_no_fk : '' }}">
            <input type="hidden" class="keep_me" id="hdn_schedule_id" name="hdn_schedule_id"
            value="{{ !empty($doc_data[0]->schedule_no_pk) ? $doc_data[0]->schedule_no_pk : '' }}">
            <input type="hidden" class="keep_me" id="hdn_patient_id" name="hdn_patient_id"
            value="{{ !empty(Auth::user()->patient_no_fk) ? Auth::user()->patient_no_fk : '' }}">

            <input type="hidden" value="{{ !empty($doc_data[0]->full_name) ? $doc_data[0]->full_name : '' }}" id="doc_id"
            name="doc_id">
            <input type="hidden" value="{{ !empty($doc_data[0]->specialization) ? $doc_data[0]->specialization : '' }}"
            id="doc_specialist" name="doc_specialist">
            <input type="hidden" value="{{ !empty($doc_data[0]->status) ? 'available' : 'unavailable' }}" id="doc_status"
            name="doc_status">
            <input type="hidden" value="" id="doc_app_mode">
            <input type="hidden" value="" id="doc_app_date">
            <input type="hidden"
            value="{{ !empty($doc_data[0]->schedule_dt) ? date('H:i', strtotime($doc_data[0]->schedule_dt)) : '' }}"
            id="doc_app_time" name="doc_app_time">
            <input type="hidden" value="{{ !empty($doc_data[0]->doctor_fee) ? $doc_data[0]->doctor_fee : 0 }}"
            id="doc_fee" name="doc_fee">
            <input type="hidden"
            value="{{ !empty(Session()->get('user.ses_user_pk_no')) ? Session()->get('user.ses_user_pk_no') : 0 }}"
            id="session_user" name="session_user">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="form-card mt-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-sucess form_label"> Patient Name<strong class="text-danger">*</strong>
                            </label>
                            <input type="text" placeholder="Enter Your Name" name="patient_first_name" id="patient_name"
                            class="form-control shadow-sm"
                            value="{{ !empty(Auth::user()->user_fullname) ? Auth::user()->user_fullname : '' }} " />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-sucess form_label"> Select Gender<strong class="text-danger">*</strong>
                            </label>
                            <select class="form-control shadow-sm pat_gender" name="patient_gender_id">
                                {{-- <option value="">Select Gender</option> --}}
                                @if (!empty($gender))
                                @foreach ($gender as $pk => $gen)
                                <option value="{{ $pk }}" {{ $pk == $gender_id ? 'selected' : '' }}>
                                    {{ $gen }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-sucess form_label"> Appointment For <strong class="text-danger">*</strong>
                                </label>
                                <select class="form-control shadow-sm available_type pat_appointmentfor"
                                name="appointment_person">
                                <option value="Self">Self</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-sucess form_label"> Phone Number <strong class="text-danger">*</strong>
                            </label>
                            <input type="text" placeholder="Enter Your Phone Number"
                            class="form-control shadow-sm pat_phone" value="{{ $mobile1 }}" name="phone" />
                        </div>
                    </div>

                    <div class="col-md-6 optional_data d-none">
                        <div class="form-group">
                            <label class="text-sucess form_label"> Relation (Optional) </label>
                            <input type="text" placeholder="Enter Relationship" class="form-control shadow-sm pat_relation"
                            value="" name="relationship" />

                            {{-- <select class="form-control shadow-sm"> --}}
                                {{-- <option>Select Appointment</option> --}}
                                {{-- <option>Father</option> --}}
                                {{-- <option>Mother</option> --}}
                                {{-- </select> --}}
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-sucess form_label"> Age <strong class="text-danger">*</strong> </label>
                                <div class="input-group">
                                    <div class="input-group-prepend w-100">
                                        <input type="number" class="form-control form-control-sm pat_info" id="pat_age_y"
                                        onkeyup="get_dob_by_age()" name="pat_age_y" value="" placeholder="YY"
                                        style="width: 35%;">
                                        <input type="number" class="form-control form-control-sm pat_info" id="pat_age_m"
                                        onkeyup="get_dob_by_age()" name="pat_age_m" value="" placeholder="MM"
                                        style="width: 33%;" max="12">
                                        <input type="number" class="form-control form-control-sm pat_info" id="pat_age_d"
                                        onkeyup="get_dob_by_age()" name="pat_age_d" value="" placeholder="DD"
                                        style="width: 32%;" max="31">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-sucess form_label"> Date of Birth <strong class="text-danger">*</strong>
                                </label>
                                {{-- <input type="text" id="patient_dob" value="{{ $dob }}" placeholder="dd/mm/yyyy"
                                class="form-control shadow-sm pat_dateofbirth date_picker datepicker" name="dob"
                                onchange="dob(event ,this)" onkeyup="dob(event,this)" /> --}}

                                <input type="text" class="form-control form-control-sm date_picker pat_info pat_dateofbirth"
                                id="patient_dob" name="pat_dob" value="" autocomplete="off" placeholder="dd-mm-yyyy"
                                onchange="dob(event ,this)" onkeyup="dob(event,this)">





                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-sucess form_label"> Email</label>
                                <input type="email" placeholder="Enter Your Email" class="form-control shadow-sm pat_email"
                                name="email" value="{{ $email }}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-sucess form_label"> Disease Details </label>
                                <textarea class="form-control shadow-sm pat_details" name="pat_details"></textarea>
                            </div>
                        </div>
                        @php
                        $hospital_code = strtoupper($po_hospital_details->hospital_code);
                        @endphp
                        @if($hospital_code !="CHPC")
                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label class="text-sucess form_label">PayMod </label>

                                <select class="form-control shadow-sm p_mod">
                                    @if (!empty($bank_name))
                                    @foreach ($bank_name as $pk => $bank)
                                    <option value="{{ $bank }}">{{ $bank }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-sucess form_label transaction_id"> Transaction Id</label>
                                <input type="text" placeholder="Enter Transaction Id " class="form-control shadow-sm t_id"
                                name="transaction_id" id="transaction_id" value="" />
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
                <button type="button" name="next" class="next action-button" id="loadBtnData"
                onclick="appFunc.loadFunc(this)">Next</button>
                <button type="button" name="previous" class="previous action-button-previous">Previous</button>
            </fieldset>



            <fieldset>
                <div class="form-card">
                    <div class="row p-3">




                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">Patient & Doctor Details</h2>
                                </div>
                                <div class="card-body">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td><label class="text-sucess confirm_label">Department </label></td>
                                            <td>:</td>
                                            <td><span class="confirm_span specialist_data"></span></td>

                                            <td><label class="text-sucess confirm_label">Patient Name </label> </td>
                                            <td>:</td>
                                            <td><span class="confirm_span pat_name" id="pat_name_data"></span></td>
                                        </tr>

                                        <tr>
                                            <td><label class="text-sucess confirm_label"> Doctor Name </label></td>
                                            <td>:</td>
                                            <td> <span class="confirm_span doctor_name_app" id=""></span></td>

                                            <td><label class="text-sucess confirm_label"> Gender </label> </td>
                                            <td>:</td>
                                            <td><span class="confirm_span pat_gender_app" id=""></span></td>
                                        </tr>

                                        <tr>
                                            <td><label class="text-sucess confirm_label"> Date </label></td>
                                            <td>:</td>
                                            <td> <span class="confirm_span" id="app_date"> </span></td>

                                            <td><label class="text-sucess confirm_label"> Mobile Number </label> </td>
                                            <td>:</td>
                                            <td><span class="confirm_span pat_mobile_num" id=""> </span></td>
                                        </tr>

                                        <tr>
                                            {{-- <td><label class="text-sucess confirm_label"> Age </label></td>
                                            <td>:</td>
                                            <td><span class="confirm_span " id="pat_age"> </span></td> --}}

                                            <td><label class="text-sucess confirm_label"> Email </label></td>
                                            <td>:</td>
                                            <td><span class="confirm_span pat_email_app" id=""> </span></td>

                                            <td><label class="text-sucess confirm_label"> Date Of Birth </label></td>
                                            <td>:</td>
                                            <td><span class="confirm_span pat_dob" id=""> </span></td>
                                        </tr>

                                        <tr>
                                            <td><label class="text-sucess confirm_label"> Fee </label></td>
                                            <td>:</td>
                                            <td><span class="confirm_span doctor_fee_app" id=""> </span></td>
                                            <td><label class="text-sucess confirm_label"> Disease Details </label></td>
                                            <td>:</td>
                                            <td><span class="confirm_span disease_details" id=""> </span></td>
                                        </tr>
                                        @if($hospital_code !="CHPC")

                                        <tr>
                                            <td><label class="text-sucess confirm_label"> Paymod </label></td>
                                            <td>:</td>
                                            <td><span class="confirm_span paymod" id=""> </span></td>
                                            <td><label class="text-sucess confirm_label"> Transaction Id </label></td>
                                            <td>:</td>
                                            <td><span class="confirm_span transaction" id=""> </span></td>
                                        </tr>
                                        @endif

                                        {{-- <tr>

                                        </tr> --}}


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
                {{-- <button type="button" class="action-button-previous pay" data-response_action="{{ $response_url }}"
                data-riderect_action="{{ $redirect_url }}" onclick="appointmentEngine.saveAppointmentForPatient(this)">Go
                for Pay</button> --}}
                {{-- <button type="submit" class="action-button-previous pay_to">Go
                    for Pay</button> //comment by nazmul --}}


                    @php
                    $response_action = route('cover.doctor-admin-panel');
                    @endphp
                    @if($hospital_code == "CHPC")
                    <button type="submit" class="action-button-previous pay" onclick="bookAppointment(this)">Confirm</button>
                    @else
                    <button type="submit" class="action-button-previous pay" onclick="payAppointment(this)">Go for Pay</button>
                    {{-- <button type="button" class="action-button-previous pay" >Go for Pay</button> --}}
                    @endif
                </fieldset>
            </form>


            @endsection

            @push('patient_customjs')
            <script>
                // $('.datepicker').datepicker({
                    //     format: 'dd-mm-yyyy',
                    //     todayHighlight: true,
                    //     clearBtn: true,
                    //     autoclose: true
                    // });

                    function payAppointment(thisElement) {

                        event.preventDefault();

                        var formID = $(thisElement).parents("form").attr("id");
                        var formAction = $(thisElement).parents("form").attr("action");
                        var formMethod = $(thisElement).parents("form").attr("method");

                        if (confirm('Are You Sure ?')) {
                            $.ajax({
                                async: true,
                                data: $('#' + formID).serialize(),
                                url: formAction,
                                type: formMethod,
                                beforeSend: function() {
                                    blockUI();
                                },
                                success: function(data) {
                                    console.log(data)
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Paid Successful',
                                        showClass: {
                                            popup: 'animate__animated animate__fadeInDown'
                                        },
                                        hideClass: {
                                            popup: 'animate__animated animate__fadeOutUp'
                                        }
                                    })
                                    // $('.user_type').val("")
                                    // $('.full_name').val("")
                                    // $('.country').val("")
                                    // $('.license_no').val("")
                                    // $('.user_email').val("")
                                    // $('.password').val("")
                                    // $('.c_password').val("")
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
                        }
                        event.stopImmediatePropagation();
                    }
                    function bookAppointment(thisElement) {

                        event.preventDefault();

                        var formID = $(thisElement).parents("form").attr("id");
                        var formAction = $(thisElement).parents("form").attr("action");
                        var formMethod = $(thisElement).parents("form").attr("method");

                        if (confirm('Are You Sure ?')) {
                            $.ajax({
                                async: true,
                                data: $('#' + formID).serialize(),
                                url: formAction,
                                type: formMethod,
                                beforeSend: function() {
                                    blockUI();
                                },
                                success: function(data) {
                                    console.log(data)
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Appointment Successful',
                                        showClass: {
                                            popup: 'animate__animated animate__fadeInDown'
                                        },
                                        hideClass: {
                                            popup: 'animate__animated animate__fadeOutUp'
                                        }
                                    })
                                    // $('.user_type').val("")
                                    // $('.full_name').val("")
                                    // $('.country').val("")
                                    // $('.license_no').val("")
                                    // $('.user_email').val("")
                                    // $('.password').val("")
                                    // $('.c_password').val("")
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
                        }
                        event.stopImmediatePropagation();
                    }
                    // appointment

                    var appFunc = {
                        loadFunc: function(thisElement) {
                            let name = $('#patient_name').val();
                            let pat_appointment_for_app = $('.pat_appointmentfor').val();
                            let pat_gender_app = $('.pat_gender option:selected').text();
                            // let pat_gender_app = $('.pat_gender').val();
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
                            let paymod = $('.p_mod option:selected').text();
                            let transaction_id = $('.t_id').val();

                            var today = new Date();
                            // let date = today.toLocaleDateString('en-GB', {
                                //     day: 'numeric',
                                //     month: 'short',
                                //     year: 'numeric'
                                // }).replace(/ /g, '-');

                                let date = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();

                                // Patient
                                $('#pat_name_data').html(name)
                                $('.appointment_status_app').html('Web')
                                $('.pat_appointment_app').html(pat_appointment_for_app)
                                $('.pat_gender_app').html(pat_gender_app)
                                $('.pat_years_app').html(pat_years_app)
                                $('.pat_mobile_num').html(pat_mobile_num)
                                $('.pat_email_app').html(pat_email_app)
                                $('.disease_details').html(pat_details)
                                $('#app_date').html(date)
                                $('.pat_dob').html(pat_dateofbirth)


                                // doctor part /
                                // alert(paymod + transaction_id)

                                $('.doctor_time_app').html(doc_app_time)
                                $('.doctor_email_app').html(name)
                                $('.doctor_fee_app').html(doc_fee)
                                $('.doctor_name_app').html(doctor_full_name)
                                $('.specialist_data').html(doc_specialist)
                                $('.paymod').html(paymod)
                                $('.transaction').html(transaction_id)

                            }
                        }



                        // Date Of Birth
                        $(document).on('keyup focus blur', '#patient_dob', function() {

                            $('.date_picker').datepicker({
                                format: 'dd-mm-yyyy',
                                autoclose: true,
                                clearBtn: true,
                                todayHighlight: true,
                            });
                        })

                        function datepic(element) {
                            $('.date_picker').datepicker({
                                format: 'dd-mm-yyyy',
                                autoclose: true,
                                clearBtn: true,
                            });
                        }

                        function get_dob_by_agee() {
                            // var pat_age_y = $('#pat_age_y').val();
                            // var pat_age_m = $('#pat_age_m').val();
                            // var pat_age_d = $('#pat_age_d').val();

                            // var cur_date = new Date();
                            // var cur_y = cur_date.getFullYear();

                            //     var dob = pat_age_d + "-" +  (pat_age_m  )+ "-" + (cur_y - pat_age_y);
                            //     var dob_year = cur_y - pat_age_y;
                            //     if((pat_age_m.length && pat_age_d.length) > 0){
                                //         $("#patient_dob").val(dob);
                                //     }else{
                                    //         $("#patient_dob").val(dob_year);
                                    //     }

                                    //     $('.date_picker').datepicker({
                                        //         format: 'dd-mm-yyyy',
                                        //         autoclose: true,
                                        //         todayHighlight: true,
                                        //         clearBtn: true,
                                        //     });
                                    }
                                    // $('.date_picker').datepicker({
                                        //     format: 'dd-mm-yyyy',
                                        //     autoclose: true,
                                        //     todayHighlight: true,
                                        //     clearBtn: true,
                                        // });
                                        function convertTZ(date, tzString) {
                                            return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {
                                                timeZone: tzString
                                            }));
                                        }

                                        function get_dob_by_age() {
                                            var pat_age_y = $('#pat_age_y').val();
                                            var pat_age_m = $('#pat_age_m').val();
                                            var pat_age_d = $('#pat_age_d').val();
                                            var date = new Date();
                                            var today = convertTZ(date, "Asia/Jakarta");
                                            var age = today.getFullYear() - pat_age_y;
                                            var m = (today.getMonth() + 1) - pat_age_m;
                                            var d = today.getDate() - pat_age_d;
                                            var month = 0;
                                            var date = 0;

                                            var pre_month = (today.getMonth());
                                            var add_days = 0;
                                            if (pre_month == 1) {
                                                add_days = 31;
                                            } else if (pre_month == 2) {
                                                add_days = 28;
                                            } else if (pre_month == 3) {
                                                add_days = 31;
                                            } else if (pre_month == 4) {
                                                add_days = 30;
                                            } else if (pre_month == 5) {
                                                add_days = 31;
                                            } else if (pre_month == 6) {
                                                add_days = 30;
                                            } else if (pre_month == 7) {
                                                add_days = 31;
                                            } else if (pre_month == 8) {
                                                add_days = 31;
                                            } else if (pre_month == 9) {
                                                add_days = 30;
                                            } else if (pre_month == 10) {
                                                add_days = 31;
                                            } else if (pre_month == 11) {
                                                add_days = 30;
                                            } else if (pre_month == 12) {
                                                add_days = 30;
                                            }
                                            if (today.getDate() < pat_age_d) {
                                                date = (today.getDate() + add_days) - pat_age_d;
                                            } else {
                                                var dates = today.getDate() - pat_age_d;
                                                if (dates == 0) {
                                                    date = ((today.getDate() + add_days) - pat_age_d);
                                                } else {
                                                    date = (today.getDate() - pat_age_d);
                                                }
                                            }

                                            if ((today.getMonth() + 1) < pat_age_m) {
                                                months = (today.getMonth() + 12 + 1) - pat_age_m;
                                                if (date == 0) {
                                                    month = (today.getMonth() + 12 + 1) - (pat_age_m);
                                                    if (month == 0) {
                                                        month += 1;
                                                    }
                                                } else {
                                                    month = (today.getMonth() + 12 + 1) - pat_age_m;
                                                    if (month == 0) {
                                                        month += 1;
                                                    }
                                                }
                                            } else {
                                                if (date == 0) {
                                                    month = (today.getMonth() + 1) - (pat_age_m);
                                                    if ((today.getMonth() + 1) > pat_age_m) {
                                                        month = (today.getMonth() + 12 + 1) - pat_age_m;
                                                    }
                                                    if (month == 0) {
                                                        month += 1;
                                                    }
                                                } else {
                                                    month = (today.getMonth() + 1) - pat_age_m;
                                                    if ((today.getMonth() + 1) > pat_age_m) {
                                                        month = (today.getMonth() + 1) - pat_age_m;
                                                    }
                                                    if (month == 0) {
                                                        month = (today.getMonth() + 1 + 12) - pat_age_m;
                                                    }
                                                    console.log(month);
                                                }
                                            }
                                            if (m < 0 || (m === 0 && today.getDate() < pat_age_d)) {
                                                age--;
                                            }
                                            if (month != 0 && today.getDate() < pat_age_d) {
                                                month--;
                                            }

                                            if ((pat_age_y.length) > 0) {
                                                $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + 1).slice(-2) + "-" + age);
                                            }
                                            if ((pat_age_y.length && pat_age_m.length) > 0) {
                                                $("#patient_dob").val(('0' + 1).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
                                            }
                                            if ((pat_age_y.length && pat_age_m.length && pat_age_d.length) > 0) {
                                                $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + age);
                                            }


                                        }



                                        function dob(event, element) {
                                            var code = event.keyCode || event.which;

                                            if (code != '9') {

                                                $('.date_picker').datepicker({
                                                    format: 'dd-mm-yyyy',
                                                    autoclose: true,
                                                    todayHighlight: true,
                                                    clearBtn: true,
                                                });

                                                var dateString = $(element).val();
                                                if (dateString.indexOf('.')) {
                                                    var dob = dateString.split(".");
                                                    dateString = dob[0] + "-" + dob[1] + "-" + dob[2];
                                                }
                                                if (dateString.indexOf('/')) {
                                                    var dob = dateString.split("/");
                                                    dateString = dob[0] + "-" + dob[1] + "-" + dob[2];
                                                } else {
                                                    dateString = $(element).val();
                                                }


                                                var dob = dateString.split("-");
                                                var date = new Date();
                                                var now = convertTZ(date, "Asia/Jakarta");
                                                var today = new Date(now.getYear(), now.getMonth(), now.getDate());
                                                var yearNow = now.getFullYear();
                                                var monthNow = 1 + now.getMonth();
                                                var dateNow = now.getDate();
                                                var yearDob = dob[2];
                                                var monthDob = dob[1];
                                                var dateDob = dob[0];
                                                var age = {};
                                                var ageString = "";
                                                var yearString = "";
                                                var monthString = "";
                                                var dayString = "";
                                                yearAge = yearNow - yearDob;

                                                if ((parseFloat(monthNow)) > monthDob) {
                                                    var monthAge = (parseFloat(monthNow)) - monthDob;

                                                } else {
                                                    yearAge--;
                                                    var monthAge = (12 + parseFloat(monthNow)) - monthDob;

                                                }
                                                if (dateNow > dateDob) {
                                                    var dateAge = dateNow - dateDob;
                                                } else {
                                                    monthAge--;

                                                    var pre_month = parseFloat(monthNow);
                                                    var add_days = 0;
                                                    if (pre_month == 1) {
                                                        add_days = 31;
                                                    } else if (pre_month == 2) {
                                                        add_days = 28;
                                                    } else if (pre_month == 3) {
                                                        add_days = 31;
                                                    } else if (pre_month == 4) {
                                                        add_days = 30;
                                                    } else if (pre_month == 5) {
                                                        add_days = 31;
                                                    } else if (pre_month == 6) {
                                                        add_days = 30;
                                                    } else if (pre_month == 7) {
                                                        add_days = 31;
                                                    } else if (pre_month == 8) {
                                                        add_days = 31;
                                                    } else if (pre_month == 9) {
                                                        add_days = 30;
                                                    } else if (pre_month == 10) {
                                                        add_days = 31;
                                                    } else if (pre_month == 11) {
                                                        add_days = 30;
                                                    } else if (pre_month == 12) {
                                                        add_days = 30;
                                                    }
                                                    var dateAge = (parseFloat(add_days) + parseFloat(dateNow)) - dateDob;
                                                }
                                                age = {
                                                    years: yearAge,
                                                    months: monthAge,
                                                    days: dateAge
                                                };
                                                var m = now.getMonth() - monthDob;
                                                if (m < 0 || (m === 0 && today.getDate() < dateDob)) {
                                                    yearAge--;
                                                }
                                                if ((age.years >= 0) && (age.months >= 0) && (age.days >= 0))
                                                ageString = age.years + "-" + age.months + "-" + age.days;
                                                var pieces = ageString.split("-");
                                                $("#pat_age_y").val(pieces[0]);
                                                $("#pat_age_m").val(pieces[1]);
                                                $("#pat_age_d").val(pieces[2]);
                                            }

                                        }
                                    </script>
                                    @endpush
