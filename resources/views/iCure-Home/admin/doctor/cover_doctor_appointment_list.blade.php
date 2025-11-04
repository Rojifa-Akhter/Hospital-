<div class="tab-menu-heading">
    <div class="tabs-menu">
        <!-- Tabs -->
        <ul class="nav panel-tabs">
            <li class="">
                <a href=" #online_appointment" class="active" data-toggle="tab"
                onclick="app.toDayApp(this)" data-tab-type="5" data-action="{{ route('admin.appointment-list') }}"><i
                    class="fe fe-airplay mr-1"></i> Online
                Appointments</a>
            </li>
            <li>
                <a href="#offline_appointment" data-toggle="tab" class="" onclick=" app.toDayApp(this)"
                    data-tab-type="6" data-action="{{ route('admin.appointment-list') }}"><i
                        class="fe fe-package mr-1"></i> Offline
                    Appointments</a>
            </li>
        </ul>
    </div>
</div>

<div class="panel-body tabs-menu-body">
    <div class="tab-content">
        <div class="tab-pane active" id="online_appointment">
            <div class="row">
                @if (!empty($appointment_data))
                    @foreach ($appointment_data as $appointment_row)
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="chat-widget-header d-flex p-5 align-items-center">
                                        <div
                                            class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                            <div class="mt-1">
                                                <h6 class="font-weight-semibold mb-0">{{ $loop->iteration }}</h6>
                                            </div>
                                        </div>

                                        <div
                                            class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                            <div class="mt-1">
                                                <h6 class="font-weight-semibold mb-0">App. ID</h6>
                                                <small>{{ !empty($appointment_row->appoint_code) ? $appointment_row->appoint_code : '' }}</small>
                                            </div>
                                        </div>

                                        <div class="font-weight-bold d-flex pr-4 mr-4 border-right align-items-center">
                                            @if ($appointment_row->patient_photo != '')
                                                <img class="avatat avatar-md brround mr-2"
                                                    src="{{ asset('images/uploads/patient_images/thumb/' . $appointment_row->patient_photo) }}">
                                            @else
                                                @if ($appointment_row->gender_txt == 'Male')
                                                    <img class="avatat avatar-md brround mr-2"
                                                        src="{{ asset('images/boy.jpg') }}" alt="">
                                                @else
                                                    <img class="avatat avatar-md brround mr-2"
                                                        src="{{ asset('images/boy.jpg') }}" alt="">
                                                @endif
                                            @endif
                                            {{-- <img class="avatat avatar-md brround mr-2" src="../../assets/images/users/1.jpg" --}}
                                            {{-- alt="img"/> --}}

                                            <div class="mt-1 d-none d-sm-block">
                                                <h6 class="font-weight-semibold mb-0">
                                                    {{ !empty($appointment_row->patient_name) ? ucfirst($appointment_row->patient_name) : '' }}
                                                </h6>
                                                <small><strong>Age :</strong>
                                                    {{ !empty($appointment_row->age) ? $appointment_row->age : '' }},
                                                    {{ !empty($appointment_row->gender_txt) ? $appointment_row->gender_txt : '' }}</small>
                                            </div>
                                        </div>

                                        <div
                                            class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                            <div class="mt-1">
                                                <h6 class="font-weight-semibold mb-0">Chief Complaint</h6>
                                                <small>{{ !empty($appointment_row->chif_complain) ? $appointment_row->chif_complain : '' }}</small>
                                            </div>
                                        </div>

                                        <div
                                            class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                            <div class="mt-1">
                                                <h6 class="font-weight-semibold mb-0">App Status</h6>
                                                <small>Follow Up, Video Call</small>
                                            </div>
                                        </div>

                                        <div class="ml-auto">
                                            <div class="d-flex">
                                                <a class="option-dots new-list2" target="_blank"
                                                    title="Electronic medical report" data-toggle="tooltip"
                                                    href="{{ route('emr.doctor-emr-data', $appointment_row->patient_no_pk) }}"><i
                                                        class="fa fa-file-medical-alt"></i></a>

                                                <a class="option-dots new-list2" href="#" data-toggle="modal"
                                                    data-target="#chatmodel" data-toggle="tooltip" title="Chat"><i
                                                        class="fe fe-message-square"></i></a>
                                                <a class="option-dots new-list2" href="{{ route('video-call') }}"
                                                    data-placement="top" data-toggle="tooltip" title="Call"><i
                                                        class="fe fe-phone"></i></a>
                                                <a class="option-dots new-list2" href="{{ route('video-call') }}"
                                                    data-placement="top" data-toggle="tooltip" title="Video Cal"><i
                                                        class="fe fe-video"></i></a>
                                                <a class="option-dots new-list2"
                                                    href="{{ route('doctor-prescription.create-doctor-wise', $appointment_row->appoint_no_pk) }}"
                                                    data-toggle="tooltip" title="Prescription"><i
                                                        class="fa fa-prescription"></i></a>
                                                <a class="option-dots new-list2" data-toggle="dropdown" href="#"><i
                                                        class="fe fe-more-vertical"></i></a>

                                                <div class="dropdown-menu tx-13 dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">Refer to</a>
                                                    <a class="dropdown-item" href="#">Mark As Absent</a>
                                                    <a class="dropdown-item" href="#">Mark As Prescribed</a>
                                                    <a class="dropdown-item" href="#">Add to Queue</a>
                                                    <a class="dropdown-item" href="#">Move to Trash</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
        <div class="tab-pane" id="offline_appointment">
            <div class="row">
                @if (!empty($appointment_data))
                    @foreach ($appointment_data as $appointment_row)
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="chat-widget-header d-flex p-5 align-items-center">
                                        <div
                                            class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                            <div class="mt-1">
                                                <h6 class="font-weight-semibold mb-0">{{ $loop->iteration }}</h6>
                                            </div>
                                        </div>

                                        <div
                                            class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                            <div class="mt-1">
                                                <h6 class="font-weight-semibold mb-0">App. ID</h6>
                                                <small>{{ !empty($appointment_row->appoint_code) ? $appointment_row->appoint_code : '' }}</small>
                                            </div>
                                        </div>

                                        <div class="font-weight-bold d-flex pr-4 mr-4 border-right align-items-center">
                                            {{-- <img class="avatat avatar-md brround mr-2" src="../../assets/images/users/1.jpg" --}}
                                            {{-- alt="img"/> --}}
                                            @if ($appointment_row->patient_photo != '')
                                                <img class="avatat avatar-md brround mr-2"
                                                    src="{{ asset('images/uploads/patient_images/thumb/' . $appointment_row->patient_photo) }}">
                                            @else
                                                @if ($appointment_row->gender_txt == 'Male')
                                                    <img class="avatat avatar-md brround mr-2"
                                                        src="{{ asset('images/boy.jpg') }}" alt="">
                                                @else
                                                    <img class="avatat avatar-md brround mr-2"
                                                        src="{{ asset('images/boy.jpg') }}" alt="">
                                                @endif
                                            @endif
                                            <div class="mt-1 d-none d-sm-block">
                                                <h6 class="font-weight-semibold mb-0">
                                                    {{ !empty($appointment_row->patient_name) ? ucfirst($appointment_row->patient_name) : '' }}
                                                </h6>
                                                <small><strong>Age :</strong>
                                                    {{ !empty($appointment_row->age) ? $appointment_row->age : '' }},
                                                    {{ !empty($appointment_row->gender_txt) ? $appointment_row->gender_txt : '' }}</small>
                                            </div>
                                        </div>

                                        <div
                                            class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                            <div class="mt-1">
                                                <h6 class="font-weight-semibold mb-0">Chief Complaint</h6>
                                                <small>{{ !empty($appointment_row->chif_complain) ? $appointment_row->chif_complain : '' }}</small>
                                            </div>
                                        </div>

                                        <div
                                            class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                            <div class="mt-1">
                                                <h6 class="font-weight-semibold mb-0">App Status</h6>
                                                <small>Follow Up, Chamber</small>
                                            </div>
                                        </div>

                                        <div class="ml-auto">
                                            <div class="d-flex">
                                                <a class="option-dots new-list2" target="_blank"
                                                    title="Electronic medical report" data-toggle="tooltip"
                                                    href="{{ route('emr.doctor-emr-data', $appointment_row->patient_no_pk) }}"><i
                                                        class="fa fa-file-medical-alt"></i></a>
                                                <a class="option-dots new-list2"
                                                    href="{{ route('doctor-prescription.create-doctor-wise', $appointment_row->appoint_no_pk) }}"
                                                    data-toggle="tooltip" title="Prescription"><i
                                                        class="fa fa-prescription"></i></a>
                                                <a class="option-dots new-list2" data-toggle="dropdown" href="#"><i
                                                        class="fe fe-more-vertical"></i></a>
                                                <div class="dropdown-menu tx-13 dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">Refer to</a>
                                                    <a class="dropdown-item" href="#">Mark As Absent</a>
                                                    <a class="dropdown-item" href="#">Mark As Prescribed</a>
                                                    <a class="dropdown-item" href="#">Add to Queue</a>
                                                    <a class="dropdown-item" href="#">Move to Trash</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
