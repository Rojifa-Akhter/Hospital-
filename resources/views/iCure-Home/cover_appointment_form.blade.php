<form id="msform" method="post" action="{{ route('cover.appointment-store') }}">

    @csrf
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

        <input type="hidden" value="{{ !empty($doc_data[0]->full_name) ? $doc_data[0]->full_name : '' }}" id="doc_id">
        <input type="hidden" value="{{ !empty($doc_data[0]->specialization) ? $doc_data[0]->specialization : '' }}"
            id="doc_specialist">
        <input type="hidden" value="{{ !empty($doc_data[0]->status) ? 'available' : 'unavailable' }}" id="doc_status">
        <input type="hidden" value="" id="doc_app_mode">
        <input type="hidden" value="" id="doc_app_date">
        <input type="hidden"
            value="{{ !empty($doc_data[0]->schedule_dt) ? date('H:i', strtotime($doc_data[0]->schedule_dt)) : '' }}"
            id="doc_app_time">
        <input type="hidden" value="{{ !empty($doc_data[0]->doctor_fee) ? $doc_data[0]->doctor_fee : 0 }}" id="doc_fee">
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
                        <select class="form-control shadow-sm pat_gender" name="patient_gender">
                            <option value="">Select Gender</option>
                            {{-- <option value="Male">Male</option> --}}
                            {{-- <option value="Female">Female</option> --}}
                            {{-- <option value="Other">Other's</option> --}}
                            @if (!empty($gender))
                                @foreach ($gender as $pk => $gen)
                                    <option value="{{ $pk }}">{{ $gen }}</option>
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
                            <option value="">Select Appointment</option>
                            <option value="self">Self</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-sucess form_label"> Phone Number <strong class="text-danger">*</strong>
                        </label>
                        <input type="text" placeholder="Enter Your Phone Number"
                            class="form-control shadow-sm pat_phone"
                            value="{{ !empty(Auth::user()->phone_mobile) ? Auth::user()->phone_mobile : '' }}"
                            name="phone" />
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
                        <label class="text-sucess form_label"> Email <strong class="text-danger">*</strong> </label>
                        <input type="email" placeholder="Enter Your Email" class="form-control shadow-sm pat_email"
                            name="email" value="{{ !empty(Auth::user()->email) ? Auth::user()->email : '' }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-sucess form_label"> Date of Birth <strong class="text-danger">*</strong>
                        </label>
                        <input type="date" class="form-control shadow-sm pat_dateofbirth" name="hdn_appointment_date" />
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
            onclick="appFunc.loadFunc(this)">Next</button>
        <button type="button" name="previous" class="previous action-button-previous">Previous</button>
    </fieldset>

    <fieldset>
        <div class="form-card">
            <div class="row p-3">
                <div class="col-md-6">
                    <div class="form-group"><label class="text-sucess confirm_label"> Department :</label><span
                            class="confirm_span specialist_data"></span></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"><label class="text-sucess confirm_label"> Patient Name : </label> <span
                            class="confirm_span pat_name" id="pat_name_data"></span></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group"><label class="text-sucess confirm_label"> Doctor Name : </label> <span
                            class="confirm_span doctor_name_app" id=""></span></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group"><label class="text-sucess confirm_label"> Appointment for : </label>
                        <span class="confirm_span pat_appointment_for_app" id=""></span></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group"><label class="text-sucess confirm_label"> Appointment Status : </label>
                        <span class="confirm_span appointment_status_app" id=""></span></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group"><label class="text-sucess confirm_label"> Gender : </label> <span
                            class="confirm_span pat_gender_app" id=""></span></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group"><label class="text-sucess confirm_label"> Appointment Mode : </label>
                        <span class="confirm_span appointment_mode_app" id=""></span></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group"><label class="text-sucess confirm_label"> Patient Age : </label> <span
                            class="confirm_span pat_years_app" id=""></span></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group"><label class="text-sucess confirm_label"> Date: </label> <span
                            class="confirm_span" id="app_date"> </span></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group"><label class="text-sucess confirm_label"> Mobile Number : </label> <span
                            class="confirm_span pat_mobile_num" id=""> 017000000 </span></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group"><label class="text-sucess confirm_label"> Time : </label> <span
                            class="confirm_span " id=""> {{ date('H:i') }} </span></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group"><label class="text-sucess confirm_label"> Email : </label> <span
                            class="confirm_span pat_email_app" id=""> xx@example.com </span></div>
                </div>

                <div class="col-md-6">
                    <div class="form-group"><label class="text-sucess confirm_label"> Fee : </label> <span
                            class="confirm_span doctor_fee_app" id=""> 150 $ </span></div>
                </div>
            </div>
        </div>

        <button type="button" class="previous action-button reset">Reset</button>
        @php
            $appoint_id = '';
            $response_url = route('appointment-card-pat', $appoint_id);
            $redirect_url = route('appointments.create');
        @endphp
        <button type="button" class="action-button-previous pay" data-response_action="{{ $response_url }}"
            data-redirect-action="{{ $redirect_url }}" onclick="appointmentEngine.saveAppointment(this)">Go for
            Pay</button>


        {{-- @php --}}
        {{-- $response_action = route('cover.doctor-admin-panel'); --}}
        {{-- @endphp --}}
        {{-- <button type="submit"   class="action-button-previous pay" onclick="payAppointment(this)">Go for Pay</button> --}}
        {{-- <button type="button" class="action-button-previous pay" >Go for Pay</button> --}}
    </fieldset>
</form>

@push('custom_js')
    <script>
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
    </script>
@endpush
