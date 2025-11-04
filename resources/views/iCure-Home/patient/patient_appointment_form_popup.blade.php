<div class="doctor_appointment_area" id="appointment">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <div class="section_title_area about_us_section">
                    <h3 class="section_title2">Make Your Appointment</h3>
                    <p class="sub_title">From emergency department care to remote patient monitoring for chronic care management .and access to care from specialists</p>

                    <h4 class="instraction_for_appointment">Complete Three Steps for Your Appointment</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 card shadow-sm m-auto" style="background-color:transparent;">
            {{--                    <form id="msform" method="post" action="{{ route('cover.appointment-store') }}">--}}

            {{--                    @csrf--}}
            <!-- progressbar -->
                <ul id="progressbar">
                    <li class="active schedule" id="account"><strong></strong></li>
                    <li id="personal" class="patient"><strong> </strong></li>
                    <li id="payment" class="confirm"><strong> </strong></li>
                </ul>

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
                                        @if(!empty($docspl))
                                            @foreach($docspl as $spe_name)
                                                <option
                                                    value="{{ $spe_name->specialization_id }}">{{ $spe_name->specialization_name }}
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

                                {{--                                        <div class="form-group">--}}
                                {{--                                            <label class="text-success form_label">Available Date</label>--}}
                                {{--                                            <input type="date" class="form-control shadow-sm" id="apointment_date" name="apointment_date" value="" placeholder="Enter Schedule Date" />--}}
                                {{--                                        </div>--}}

                                {{--                                        <div class="form-group">--}}
                                {{--                                            <label class="text-success form_label">Available Time</label>--}}
                                {{--                                            <input type="time" class="form-control shadow-sm" placeholder="--:--:--" />--}}
                                {{--                                        </div>--}}

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


                            <div class="col-md-7"
                                 style="height:588px;overflow-x: hidden;overflow-y: scroll;">
                                <span class="form_title text-success pb-3 doctor_list">List Of available doctors according to your department and required day</span>

                                @if(!empty($doctor_list))
                                    @foreach( $doctor_list as $doctor_row)
                                        <div class="doctor_list custom-card" id="doctor_list">
                                            <div class="card shadow-sm mb-2 d-flex flex-row doctor_card">
                                                <div class="doctor_img">
                                                    @if ($doctor_row->photo_name != '')
                                                        <img
                                                            src="{{ asset('images/uploads/patient_images/thumb/' . $doctor_row->photo_name) }}"
                                                            width="150px"/>

                                                    @else
                                                        <img src="{{asset('coverpage/./img/doctor-1.jpg')}}"
                                                             width="150px"/>
                                                    @endif
                                                </div>

                                                <div
                                                    class="info_select w-100 d-flex flex-row justify-content-between">

                                                    <div class="doctor_info open-modal"
                                                         data-modal="common-modal-sm">
                                                        <h4><span
                                                                id="doctor_full_name">{{!empty($doctor_row->full_name)?$doctor_row->full_name:""}}</span>
                                                        </h4>
                                                        <h6 class="py-1 doctor_des"> MBBS,DCO,MPHO</h6>
                                                        <p><span class="ava_id"
                                                                 id="ava_id">Available Date: {{!empty($doctor_row->schedule_dt)?date("d/m/Y",strtotime($doctor_row->schedule_dt)):"N/A"}}</span>
                                                        </p>
                                                        <p><span
                                                                class="time">Available Time:</span> {{!empty($doctor_row->start_time)?date("h:m:s",strtotime($doctor_row->start_time)):"N/A"}}
                                                        </p>
                                                        <p><span
                                                                class="fee">Doctor Fee:</span> {{!empty($doctor_row->doctor_fee)?$doctor_row->doctor_fee:0}}
                                                        </p>
                                                        <p><i class="fas fa-map-marker-alt medical"></i>
                                                            Dhaka Medical</p>
                                                    </div>

                                                    <div class="doctor_select_btn">
                                                        {{--                                                                        <span class="badge badge-sm badge-success cursor-pointer doctor_select p-1" data-doc-id="{{ $doctor_row->person_no_pk }}"><i class="fa fa-calendar"></i> Book Appointment</span>--}}

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
                    {{--                            <button class="btn btn-theme2 font-size-12" data-toggle="modal" data-target="#bookAppointment"  >Book Appointment</button>--}}
                    {{--                            <button type="button" name="next" class="next action-button" data-toggle="modal" data-target="#bookAppointment">Next</button>--}}
                    <button type="button" name="next" class="next action-button">Next</button>
                </fieldset>


                <!-- fieldsets -->

                @include('iCure-Home.cover_appointment_form')
                {{--                    </form>--}}
            </div>
        </div>
    </div>
</div>
