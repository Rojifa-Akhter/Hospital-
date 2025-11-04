<div class="form-row">
    @php

    @endphp
    @if (!empty($appointment_rs))
        @foreach ($appointment_rs as $data)
            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="user-card">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <div class="image">

                                @if ($data->patient_photo != '')
                                    <img class="w-100"
                                        src="{{ asset('images/uploads/patient_images/thumb/' . $data->patient_photo) }}">
                                @else
                                    @if ($data->gender_txt == 'Male')
                                        <img class="w-100" src="{{ asset('images/boy.jpg') }}" alt="">
                                    @elseif ($data->gender_txt == 'Female')
                                        <img class="w-100" src="{{ asset('images/girl.jpg') }}" alt="">
                                    @else
                                        <img class="w-100" src="{{ asset('images/boy.jpg') }}" alt="">
                                    @endif
                                @endif
                            </div>

                            <div class="details">
                                <h4>{{ !empty($data->patient_name) ? ucfirst($data->patient_name) : '' }}</h4>
                                <h6>Age: {{ !empty($data->age) ? $data->age : '' }}, Gender:
                                    {{ !empty($data->gender_txt) ? $data->gender_txt : '' }}</h6>
                                <h6>Appointment Date:
                                    {{ !empty($data->appoint_date) ? date('d/m/Y', strtotime($data->appoint_date)) : '' }}
                                </h6>
                                <h6>{{ $data->specialization }}</h6>
                                <h6> {{ $data->full_name }}</h6>
                                <h6>Serial: {{ $data->slot_sl }}</h6>
                                @if (!empty($data->opd_ns_vitals_ind) && $data->opd_ns_vitals_ind == 1)
                                    <span class="badge badge-success mt-3">Appointed (Vitals Taken)</span>
                                @else
                                    <span class="badge badge-primary mt-3">Appointed</span>
                                @endif
                                @if ($data->appoint_status == 2)
                                    <span class="badge badge-info mt-3">Prescribed</span>
                                @endif
                            </div>

                            <div class="actions">
                                <div class="btn-group btn-block">
                                    <button class="btn btn-md btn-outline-success" id="btn_emr"
                                        emr-attr="{{ $data->patient_no_pk }}">EMR</button>

                                    @if ($data->appoint_status == 2)
                                        <a href="{{ route('opd_prescription_print_pdf', $data->prescription_no_pk) }}"
                                            class="btn btn-md btn-outline-success" target="_blank"
                                            data-id="{{ $data->prescription_no_pk }}" id="prescription_id"
                                            title="Print Prescription">PRESCRIPTION PRINT</a>
                                    @else
                                            @if(session()->get('user.ses_hospital_code') === 'UNICO')
                                                {{-- V2 (for hospital code "UNICO") --}}
                                                <a class="btn btn-md btn-outline-success" rel="tab"
                                                href="{{ route('v2.prescription.opd-nurse-station-vitals', $data->appoint_no_pk) }}">VITALS</a>
                                            @else
                                                {{-- V1 (Default) --}}
                                                <a class="btn btn-md btn-outline-success" rel="tab"
                                                href="{{ route('prescription.opd-nurse-station-vitals', $data->appoint_no_pk) }}">VITALS</a>
                                            @endif

                                            @if (!empty($data->opd_ns_vitals_ind) && $data->opd_ns_vitals_ind == 1)
                                            <a href="{{ route('blank-prescription-form', $data->appoint_no_pk) }}"
                                            class="btn btn-md btn-outline-success" target="_blank"
                                            data-id="" title=" Blank Print Prescription"> BLANK PRESCRIPTION PRINT</a>
                                            @endif
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    @endif


</div>
