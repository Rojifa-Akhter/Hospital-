<style>
    .disabled-link {
        pointer-events: none;
    }
</style>
<div class="form-row">


    @if (!empty($ipds_bed))
        @foreach ($ipds_bed as $data)
            <div class="col-md-4 col-lg-3 col-xl-3">
                <div class="user-card">
                    <div class="shadow-sm"
                        style="border: 1px solid chartreuse;
                                border-radius: 13px;
                                padding: 13px;height:314px;">
                        <div class="text-center">

                            <div class="form-row">
                                @if ($data->bed_status == 2)
                                    @if ($data->patient_no_fk != '')
                                        <div class="btn-group mb-4" role="group">
                                            <button id="btnGroupDrop1" type="button"
                                                class="btn btn-warning btn-md dropdown-toggle " data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                Forms
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <button type="button" class="btn btn-info btn-sm open-modal "
                                                    data-modal="common-modal-sm" data-title="Diet Input"
                                                    data-action="{{ route('ipd.input-diet', [$data->patient_no_fk, $data->admission_uid]) }}">
                                                    diet input
                                                </button>

                                                <a type="button" class="btn btn-success btn-sm  "
                                                    data-title="admitted patient details" rel="tab"
                                                    href="{{ route('ipd-intake-output.index', ['patient_id' => $data->patient_no_fk, 'admission_uid' => $data->admission_uid]) }}">
                                                    intake output form
                                                </a>

                                                <button type="button" class="btn btn-info btn-sm open-modal "
                                                    data-modal="common-modal-sm" data-title="diabetic input"
                                                    data-action="{{ route('ipd.input-diabetic', [$data->patient_no_fk, $data->admission_uid]) }}">
                                                    Diabetic Input
                                                </button>
                                            </div>
                                        </div>
                                    @endif


                                    <div class="col-md-4">
                                        <div class="btn-group mb-4" role="group">
                                            <button id="btnGroupDrop1" type="button"
                                                class="btn btn-primary btn-md dropdown-toggle " data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                Reports
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <a type="button" class="dropdown-item" target="_blank">Temparature
                                                    Chart PDF</a>

                                                <a type="button" class="dropdown-item" target="_blank">Oxygen
                                                    Saturation
                                                    PDF</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="btn-group mb-4" role="group">

                                        <a type="button" class="btn btn-success btn-sm open-modal"
                                            data-modal="common-modal" data-title="Admitted Patient Details"
                                            rel="tab"  target="_blank"
                                            href="{{ route('ipd.nurse-station-patient-details', [$data->patient_no_fk, $data->admission_uid]) }}">
                                            Treatement
                                        </a>


                                        {{-- {{ route('ipd.nurse-station-patient-details', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }} --}}
                                        {{-- <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <a type="button" class="dropdown-item" target="_blank">Temparature
                                                    Chart PDF</a>

                                                <a type="button" class="dropdown-item" target="_blank">Oxygen
                                                    Saturation
                                                    PDF</a>
                                            </div> --}}
                                    </div>
                                @else
                                    {{-- <button
                                        class="btn btn-md  {{ $data->bed_status != 2 ? 'btn-outline-danger' : 'btn-outline-success' }}  open-modal "
                                        id="Bed_details" data-modal="common-modal-md"
                                        data-action="{{ route('ipd.bed-information', $data->bed_no_pk) }}"
                                        data-title="Bed Information" bed-attr="{{ $data->bed_no_pk }}">Patient
                                        Details</button> --}}
                                    <span Class="btn btn-sm btn-outline-primary open-modal" data-id=""
                                        data-action="{{ route('ipd.ipd-admission-emergency', $data->bed_no_pk) }}"
                                        data-modal="common-modal-md"
                                        data-title="{{ $data->emergency_daycare_ind_txt }} Registration"
                                        title="Edit"><i class="fa fa-pencil-alt"></i> Register</span>
                                @endif



                            </div>












                            <div class="form-row">
                                <div class="col-md-5">

                                    <div class="image">
                                        @if (strtoupper($data->emergency_daycare_ind_txt) == 'EMERGENCY')
                                            <img class="w-100"
                                                src="{{ asset('images/uploads/hospital_images/emergency.jpg') }}">
                                        @else
                                            <img class="w-100" src="{{ asset('images/ipd.png') }}">
                                        @endif

                                    </div>
                                </div>
                                <div class="details">

                                    <h4>
                                        <div class="card-header">
                                            <span
                                                class="text-success">({{ !empty($data->emergency_daycare_ind_txt) ? ucfirst($data->emergency_daycare_ind_txt) : '' }})</span>{{ !empty($data->bed_name) ? $data->bed_name : '' }}
                                        </div>
                                    </h4>

                                    @if ($data->bed_status == 1)
                                        <span class="badge badge-info mt-3">Available</span>
                                    @elseif($data->bed_status == 2)
                                        <span class="badge badge-secondary mt-3">Occupied</span>
                                    @elseif($data->bed_status == 3)
                                        <span class="badge badge-warning mt-3">Not Ready</span>
                                    @endif
                                </div>
                            </div>






























                            @if ($data->admission_uid != '')
                                <div class="card" style="color:black">
                                    <div class="card-body">
                                        <p><strong>
                                                Admission ID
                                                :</strong>{{ !empty($data->admission_uid) ? $data->admission_uid : '' }}
                                        </p>
                                        <p><strong>
                                                Admission Date
                                                :</strong>{{ !empty($data->admission_date) ? date('d/m/Y', strtotime($data->admission_date)) : '' }}
                                        </p>
                                        {{-- <p><strong>
                                                    Patient Name :</strong>
                                                {{ !empty($data->patient_name) ? $data->patient_name : '' }},{{ !empty($data->age) ? '(' . $data->age . ')' : '' }}
                                            </p>
                                            <p><strong>
                                                    Gender
                                                    :</strong>{{ !empty($data->gender_txt) ? $data->gender_txt : '' }}
                                            </p>
                                            <p><strong>
                                                    Doctor Name
                                                    :</strong>{{ !empty($data->primary_doctor_name) ? $data->primary_doctor_name : '' }}
                                            </p> --}}
                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>






                    <div class="actions" style="text-align: center;">
                        <div class="btn-group ">

                            <button
                                class="btn btn-md  {{ $data->bed_status != 2 ? 'btn-danger' : 'btn-outline-success' }}  open-modal mr-4"
                                id="Bed_details" data-modal="common-modal-md"
                                data-action="{{ route('ipd.patient-information', $data->admission_uid) }}"
                                data-title="Bed Information" bed-attr="{{ $data->admission_uid }}"
                                {{ $data->bed_status != 2 ? 'disabled' : '' }}>Patient
                                Details</button>
                            <a href="{{ route('ipd.admission-print-pdf-emergency', [$data->admission_uid, $data->emergency_daycare_ind_txt]) }}"
                                class="btn btn-primary btn-sm cursor-pointer {{ $data->bed_status != 2 ? 'disabled-link' : '' }}"
                                target="_blank" data-id="{{ $data->admission_uid }}" id="admission_id"
                                title="Admission request form">Print Admission form</a>
                        </div>
                    </div>



                </div>

            </div>
        @endforeach
    @endif
</div>
