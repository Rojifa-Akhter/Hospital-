<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <section class="appoinment-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-12 mb-1">
                            <h5 class="mt-2 mb-0">Appointment Details</h5>
                            <small>Patient / Appointment Details</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('uhl.store-appointment') }}" method="post" id="hos-pat-appointment">
                @csrf
                <input type="hidden" name="slot_no_pk" value="{{ $scheule_info->slot_no_pk }}">
                <input type="hidden" name="hdn_schedule_id" value="{{ $scheule_info->schedule_no_fk }}">
                <input type="hidden" name="hdn_service_unit" value="{{$scheule_info->serviceunit_no_fk}}">
                {{-- <input type="hidden" name="hdn_service_unit" value="{{ $scheule_info->specialization_lookup_no_fk }}"> --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">                           
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-lg-3 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="facility__type" class="col-sm-3 col-form-label">Facility</label>
                                            <div class="col-sm-9">
                                                <select class="form-control form-control-sm" id="facility__type"
                                                    name="facility__type">
                                                    @if (!empty($hospital))
                                                        @foreach ($hospital as $row)
                                                            <option value="{{ $row->hospital_no_pk }}">
                                                                {{ $row->hospital_name }}</option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group form-row">
                                            {{-- <label for="uhid" class="col-sm-3 col-form-label">UHID / Mobile
                                                No</label> --}}
                                                <label for="uhid" class="col-sm-3 col-form-label">Search</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder=""
                                                        id="uhid" aria-label="Recipient's username"
                                                        aria-describedby="basic-addon2" />

                                                    <input type="hidden" class="form-control" id="hdn_patient_id"
                                                        name="hdn_patient_id" value="" />

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="form-group form-row">                                       
                                          
                                            <div class="col-sm-1 mt-2">
                                                <div class="input-group">
                                                    <input type="checkbox" class="" placeholder="home Service"
                                                        id="homeService" name="homeService" value="1"/>                                                

                                                </div>
                                            </div>
                                              <label for="homeService" class="col-sm-4 col-form-label"><strong>Home Service </strong></label>
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-3 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="mobile__no" class="col-sm-3 col-form-label">Mobile No</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder=""
                                                        id="mobile_no" aria-label="Recipient's username"
                                                        aria-describedby="basic-addon4" />

                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5>Patient Details : <span>(For New Patient)</span></h5>
                            </div>

                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col-lg-4">
                                        <div class="form-group form-row">
                                            <label for="uhid__reset" class="col-sm-4 col-form-label">UHID</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="uhid__reset"
                                                        placeholder="" aria-label="Recipient's username"
                                                        aria-describedby="basic-addon3" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-secondary clear-filter-btn"
                                                            type="button"
                                                            style="height: auto !important;">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="in_free_visit_ind"
                                                    id="in_free_visit_ind" value="1" />
                                                <label class="form-check-label" for="in_free_visit_ind">Complementry
                                                    Free
                                                    Visit</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="first_name" class="col-sm-4 col-form-label">Full Name<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="full_name" name="full_name" placeholder="" required
                                                    onkeyup="checkBlankSpace(this)" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12 d-none">
                                        <div class="form-group form-row">
                                            <label for="middle_name" class="col-sm-4 col-form-label">Middle Name
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="middle_name" name="" placeholder="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12 d-none">
                                        <div class="form-group form-row">
                                            <label for="last_name" class="col-sm-4 col-form-label">Last Name </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="last_name" name="" placeholder="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="dob_" class="col-sm-4 col-form-label">DOB</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control date_picker"
                                                        id="dob" name="dob"
                                                        aria-label="Recipient's username"
                                                        aria-describedby="basic-addon3" placeholder="dd-mm-yyyy" />
                                                    {{-- <div class="input-group-append">
                                                        <button class="btn btn-secondary clear-filter-btn date_picker"
                                                            type="button" style="height: auto !important;"><i
                                                                class="far fa-calendar-alt"></i></button>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="pati_age_y" class="col-sm-4 col-form-label">AGE <span
                                                    class="text-danger">*</span></label>

                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend w-100">
                                                        <input type="number" class="form-control form-control-sm"
                                                            id="pat_age_y" name="patient_age_yy" value=""
                                                            required placeholder="YY" required="" />
                                                        <input type="number" class="form-control form-control-sm"
                                                            id="pat_age_m" name="patient_age_mm" value=""
                                                            placeholder="MM" min="0" max="12" />
                                                        <input type="number" class="form-control form-control-sm"
                                                            id="pat_age_d" name="patient_age_dd" value=""
                                                            placeholder="DD" min="0" max="31" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="patient_gender" class="col-sm-4 col-form-label">Gender<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="patient_gender"
                                                    name="patient_gender" required>
                                                    <option value="">Select</option>
                                                    @if (isset($gender))
                                                        @php $i=1; @endphp
                                                        @foreach ($gender as $key => $value)
                                                            <option value="{{ $key }}">
                                                                {{ $value }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="mobile_" class="col-sm-4 col-form-label">Mobile<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="mobile" name="phone_no" minlength="11" placeholder=""
                                                    onkeyup="checkBlankSpace(this)" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="email_" class="col-sm-4 col-form-label">Email</label>
                                            <div class="col-sm-8">
                                                <input type="email" class="form-control form-control-sm"
                                                    id="email" name="patient_email" placeholder=""
                                                    onkeyup="checkBlankSpace(this)" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="appoint_note" class="col-sm-4 col-form-label">Note</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control form-control-sm" id="appoint_note" name="appoint_note" placeholder=""
                                                    onkeyup="checkBlankSpace(this)" row="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                    value="option2" />
                                                <label class="form-check-label"
                                                    for="inlineCheckbox2">Recurrence</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         
                        <div class="card">
                            <div class="card-header">
                               
                                    <h5>Appointment Details
                                        
                                        <button type="button" class="btn-sm btn-warning float-right ml-2" data-toggle="modal" data-target="#previous_adm">
                                            Previous Admission List
                                          </button>
    
                                        <button type="button" class="btn-sm btn-primary float-right" data-toggle="modal" data-target="#previous_app">
                                          Previous Appointment List
                                        </button>
                                        <span type="button" class=" float-right ml-2 mr-2" id="show_last_appointment">
                                            
                                        </span>
                                        </h5>
    
                                        <!-- Modal -->
                                        <div class="modal fade" id="previous_app" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Appointment List</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body" id="pre_appointment">
    
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                </div>
                                            </div>
                                            </div>
                                        </div>
    
                                        <div class="modal fade" id="previous_adm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Admission List</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body" id="pre_admission">
    
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="in_facility_no_fk"
                                                class="col-sm-4 col-form-label">Facility<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" id="in_facility_no_fk"
                                                    name="in_facility_no_fk" required>
                                                    @if (!empty($hospital))
                                                        @foreach ($hospital as $row)
                                                            <option value="{{ $row->hospital_no_pk }}">
                                                                {{ $row->hospital_name }}</option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="appt_status" class="col-sm-4 col-form-label">Appointment
                                                Status</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" id="appt_status"
                                                    name="appt_status">
                                                    @if (!empty($appointment_status))
                                                        @foreach ($appointment_status as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            @if (Session::get('user.ses_hospital_code') == 'UNICO')
                                            <label for="in_provider_person_no_fk"
                                                class="col-sm-4 col-form-label">Doctor<span
                                                    class="text-danger">*</span></label>
                                            @else
                                            <label for="in_provider_person_no_fk"
                                            class="col-sm-4 col-form-label">Provider<span
                                                class="text-danger">*</span></label>
                                            @endif
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm"
                                                    id="in_provider_person_no_fk" name="in_provider_person_no_fk" required>
                                                    <option value="{{ $scheule_info->doctor_person_no_fk }}">
                                                        {{ $scheule_info->full_name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="in_visit_type" class="col-sm-4 col-form-label">Visit Type<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" id="in_visit_type"
                                                    name="in_visit_type" required>
                                                    @if (!empty($visit_types))
                                                        @foreach ($visit_types as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="app_date" class="col-sm-4 col-form-label">Appt Date</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm "
                                                    id="app_date" name="app_date" placeholder="" readonly
                                                    value="{{ date('d-m-Y', strtotime($scheule_info->schedule_dt)) }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="appt_time" class="col-sm-4 col-form-label">Appt Time</label>
                                            <div class="col-sm-8">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder=""
                                                                name="start_time"id="start_time"
                                                                aria-label="Recipient's username"
                                                                aria-describedby="basic-addon5" readonly
                                                                value="{{ date('h:i a', strtotime($scheule_info->start_time)) }}" />
                                                            <input type="text" class="form-control" placeholder=""
                                                                id="end_time" name="end_time"
                                                                aria-label="Recipient's username"
                                                                aria-describedby="basic-addon5" readonly
                                                                value="{{ date('h:i a', strtotime($scheule_info->end_time)) }}" />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text" id="basic-addon5"><i
                                                                        class="far fa-clock"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <span>OR</span>
                                                    <div class="col-sm-5">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder=""
                                                                id="" aria-label="Recipient's username"
                                                                aria-describedby="basic-addon6" />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text" id="basic-addon6"><i
                                                                        class="far fa-clock"></i></span>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="appt_type" class="col-sm-4 col-form-label">Appointment Type<span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" id="appt_type"
                                                    name="appt_type" required>
                                                    <option value="">Select</option>
                                                    @if (!empty($appointment_types))                                                   
                                                        @foreach ($appointment_types as $key => $value)                                                        
                                                            <option value="{{ $key }}" >{{ $value }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    @if (Session::get('user.ses_hospital_code') != 'UNICO')
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group form-row">
                                                <label for="reason_visit" class="col-sm-4 col-form-label">Reason For
                                                    Visit</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="reason_visit" name="reason_visit" placeholder=""
                                                        onkeyup="checkBlankSpace(this)" />
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if (Session::get('user.ses_hospital_code') != 'UNICO')
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group form-row">
                                                <label for="in_case_type" class="col-sm-4 col-form-label">Case
                                                    Type</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="in_case_type"
                                                        name="in_case_type">
                                                        @if (!empty($appointment_case))
                                                            @foreach ($appointment_case as $key => $value)
                                                                <option value="{{ $key }}">{{ $value }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if (Session::get('user.ses_hospital_code') != 'UNICO')
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="referred_type" class="col-sm-4 col-form-label">Referred Type</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" id="referred_type"
                                                    name="referred_type">
                                                    <option value="Self">Self</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group form-row">
                                            <label for="referred_physician" class="col-sm-4 col-form-label">Referring
                                                Physician</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="emp_id" name="emp_id" placeholder="" />

                                                <input type="hidden" class="form-control" id="hdn_first_refer"
                                                    name="hdn_first_refer" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                @php
                    $patient_id = '';
                    $response_action = route('uhl.appointment-card', $patient_id);
                    $redirect_url = route('uhl.appointment', ['schedule_no_fk' => $scheule_info->schedule_no_fk, 'specialization_lookup_no_fk' => $scheule_info->specialization_lookup_no_fk]);
                @endphp

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">

                                            <button class="btn btn-secondary uhl_save_btn" type="button"
                                                onclick="btnSaveUpdate(this , 'afterSaveModal', '{{ $response_action }}', 'common-modal-sm', 'Appointment Card',dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">

                                                Save
                                            </button>
                                        </li>
                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn">Appointment List</button>
                                        </li>
                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary uhl_common_btn">Online Appointment
                                                Details</button></li>
                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-primary">Notes
                                                <span class="badge badge-light">1</span></button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </section>
</main>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>



<script>
    openPatientAutocomplete('#uhid', 'patient_name', patientInfo);
    openPatientAutocomplete('#mobile_no', 'patient_name', patientInfo);
    openDoctorAutocomplete('#emp_id', 'hdn_first_refer', 'doctor_ind', '1');

    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
    }).on("change", function() {

        $.ajax({
            url: "{{ route('registration.calculateagebydatev2') }}",
            method: "post",
            data: {
                patient_dob: $('#dob').val()
            },
            success: function(res) {
                //alert(res.new_year + "," +res.new_month +",")
                $('#pat_age_m').val(res.new_month);
                $('#pat_age_y').val(res.new_year)
                $('#pat_age_d').val(res.new_day)
            }
        })
    });

    $('body').on('focusout', '#pat_age_y', function() {
        $.ajax({
            url: "{{ route('registration.calculateage-v2') }}",
            method: "post",
            beforeSend: function() {
                blockUI();

            },
            data: {
                age_year: $(this).val(),
                age_month: $('#pat_age_m').val(),
                age_day: $('#pat_age_d').val()
            },
            success: function(res) {
                $('#dob').val(res.patient_age);
                $("#dob").datepicker("setDate", res.patient_age);

            },
            complete: function() {
                $.unblockUI();
            }
        })
    })

    $('body').on('focusout', '#pat_age_m', function() {
        $.ajax({
            url: "{{ route('registration.calculateage-v2') }}",
            method: "post",
            beforeSend: function() {
                blockUI();

            },
            data: {
                age_year: $('#pat_age_y').val(),
                age_month: $(this).val(),
                age_day: $('#pat_age_d').val()
            },
            success: function(res) {
                $('#dob').val(res.patient_age);
                $("#dob").datepicker("setDate", res.patient_age);
            },
            complete: function() {
                $.unblockUI();
            }
        })
    })

    $('body').on('focusout', '#pat_age_d', function() {
        $.ajax({
            url: "{{ route('registration.calculateage-v2') }}",
            method: "post",
            beforeSend: function() {
                blockUI();

            },
            data: {
                age_year: $('#pat_age_y').val(),
                age_month: $('#pat_age_m').val(),
                age_day: $(this).val()
            },
            success: function(res) {
                $('#dob').val(res.patient_age);
                $("#dob").datepicker("setDate", res.patient_age);
            },
            complete: function() {
                $.unblockUI();
            }
        })
    })

    function patientInfo(item, obj) {
        $("#uhid__reset").val(item.patient_code);
        $("#full_name").val(item.patient_name);
        // $("#pat_age_y").val(item.age_yy);
        // $("#pat_age_m").val(item.age_mm);
        // $("#pat_age_d").val(item.age_dd);
        $("#dob").val(item.dob);
        $("#mobile").val(item.phone_mobile);
        $("#email").val(item.email);
        $("#patient_gender").val(item.gender_no_fk);

        let patient_age=item.age;
       
        if (patient_age !='') {
       
            // Regular expression to match the components
            var regex = /(\d+)\s*(Y|M|D)/g;
            var result = {};
            
            // Execute the regex and populate the result object
            while (match = regex.exec(patient_age)) {
                var value = parseInt(match[1]);
                var unit = match[2];

                result[unit] = value;
            }
            console.log(patient_age,regex.exec(patient_age))

            // Display the result       
            $("#pat_age_y").val(result['Y'] || 0);
            $("#pat_age_m").val(result['M'] || 0);
            $("#pat_age_d").val(result['D'] || 0);
        }


        var action = '{{ route("get-doctor-patient-appointment-info") }}';
		    $.ajax({
			url: action,
			data: {
				doctor_click_id:  $("#in_provider_person_no_fk option:selected").val(),
				patient_id: item.patient_id
			},
			type: "post",
			beforeSend: function() {
				blockUI();
			},
			success: function(data) {
                
                if (data.appointment_info) {
                  
                    let last_date=data.appointment_info.length > 0? new Date(data.appointment_info[0].appoint_date):'';
                    // console.log(data.appointment_info.length )
                    let last_app_date=data.appointment_info.length > 0? `<span class='p-2 border border-primary rounded'>Last Appointment Date : ${last_date.getDate()}/ ${last_date.getMonth()+1}/ ${last_date.getFullYear()} - ${data.appointment_info[0].appoint_typename}<span/>`:'';
                    $("#show_last_appointment").html(last_app_date);
					var app_date='<table class="table data-table  table-bordered table-hover table-striped"><tbody>';
					$.each(data.appointment_info, function(index, value) {
						var date=new Date(value.appoint_date);
						app_date +=`<tr><td class="w-2">${++index}</td><td class="text-center"> ${date.getDate()}/ ${date.getMonth()+1}/ ${date.getFullYear()}</td><td class="text-center">${value.appoint_typename}</td></tr>`;
					});
					app_date+='</tbody></table>';
					$("#pre_appointment").html(app_date);
				}

                if (data.admission_info) {
					var adm_date='<table class="table data-table  table-bordered table-hover table-striped"><thead><tr><td class="text-center">#SL</td><td class="text-center">Discharge Date</td><td class="text-center">Admission ID</td></tr></thead><tbody>';
					$.each(data.admission_info, function(index, value) {
						var date=new Date(value.dis_date);
						adm_date +=`<tr><td class="w-2">${++index}</td><td class="text-center"> ${date.getDate()}/ ${date.getMonth()+1}/ ${date.getFullYear()}</td><td class="text-center">${value.admission_uid}</td></tr>`;
					});
					adm_date+='</tbody></table>';
					$("#pre_admission").html(adm_date);
				}
			},
			complete: function(data) {
				$.unblockUI();
			}

		});
        //     $("#dob").datepicker("setDate", item.patient_age);
    }
</script>
