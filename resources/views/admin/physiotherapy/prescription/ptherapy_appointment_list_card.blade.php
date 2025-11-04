@include('admin.appointment.appointment_list_header_stat')
<div class="card-body pt-2 bg-light">
    <div class="row filter-container list_view">

        @if(!empty($appointment_rs))
        @foreach($appointment_rs as $row)
        @php $bg_color = ($row->prescription_no_pk != "")? "background-image:linear-gradient(#d3edfb, rgba(255,255,255,.5))":""; @endphp
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
            <div class="custom-card" style="{{ $bg_color }}">
                <div class="row no-gutters">
                    <div class="col-md-4 text-center">
                        <div class="doctor_img">
                            @if ($row->patient_photo != null)
                            <img class="rounded" src="{{ asset('images/uploads/patient_images/thumb/'.$row->patient_photo) }}">
                            @else
                            @if($row->gender_txt == 'Male')
                            <img class="w-100" src="{{ asset('images/pt-patient.jpg') }}">
                            @else
                            <img class="w-100" src="{{ asset('images/female.jpg') }}">
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="custom-card-body p-0">
                            <div class="informations text-left">
                                <span class="doctor_address">Patient ID : {{ $row->patient_code }}</span>
                                <span class="doctor_name">{{ $row->patient_name }}</span>
                                <span class="doctor_address">
                                    {{ $row->gender_txt }},
                                    @if($row->age > 0)
                                    {{ $row->age }} yrs,
                                    @endif
                                    {{ $row->mobile1 }}</span>
                                </div>
                                <div class="doc_actions text-center">
                                    <div>
                                        <span class="badge badge-sm badge-primary cursor-pointer open-modal p-1" data-action="{{ route('registration.show', $row->patient_no_pk) }}" data-title="View Patient Details" title="View Patient Details" data-modal="common-modal"><i class="fa fa-user"></i> Profile</span>

                                        <span class="badge badge-md badge-success open-modal p-1 mb-1 cursor-pointer" data-id="{{ $row->appoint_no_pk }}" data-action="{{ route('appointment-card-pat',$row->appoint_no_pk) }}" data-title="Appointment card" title="Appointment card" data-modal="common-modal-sm"><i class="fa fa-credit-card"></i> App. card</span>
                                        @if($row->consult_ind == "0")
                                        <span class="badge badge-md badge-danger mb-1 cursor-pointer" data-id="{{ $row->appoint_no_pk }}" onclick="cancelById(this)" data-url="{{ route('cancel-appointment', $row->appoint_no_pk) }}" title="Cancel this appointment"><i class="oi oi-circle-x"></i> Cancel</span>
                                        @endif
                                    </div>

                                    <div>
                                        @if($row->consult_ind == "1")
                                        <span class="badge badge-sm badge-secondary cursor-pointer open-modal p-1 cursor-pointer" data-id="{{ $row->appoint_no_pk }}" data-action="{{ route('bill-invoice-appointment', $row->appoint_no_pk) }}" data-title="Appointment Consultation Invoice" title="View Appointment Consultation Invoice" data-modal="common-modal-md"><i class="fa fa-file-invoice-dollar"></i> Invoice</span>

                                        <a href="{{ route('billing_appointment_invoice_pdf',$row->appoint_no_pk) }}" target="_blank"Class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" title="Print Appointment Consultation Invoice"><i class="fa fa-print"></i> Print</a>
                                        @else
                                        @php
                                        $action_url = route('appointments.appointment_consulation_confirm',$row->appoint_no_pk);
                                        $response_url = route('bill-invoice-appointment',$row->appoint_no_pk);
                                        @endphp
                                        <span class="badge badge-md badge-secondary p-1 mb-1 cursor-pointer" data-action="{{ $action_url }}" id="btnConsulationConfirm" data-response-action="{{ $response_url }}" title="Appointment Consultation Bill" ><i class="fa fa-dollar-sign"></i> Pay Consultation Bill</span>
                                        @endif
                                    </div>

                                    <div>
                                        @if($row->prescription_no_pk == "")
                                        <a class="badge badge-md badge-info text-white open-modal p-1 mb-1 cursor-pointer" href="{{ route('prescription-entry',[$row->appoint_no_pk,$row->patient_no_pk]) }}" rel="tab"><i class="fa fa-prescription"></i> Prescription</span></a>
                                        @else
                                        <span class="badge badge-md badge-info text-white open-modal p-1 mb-1 cursor-pointer" data-action="{{ route('prescription-print',$row->prescription_no_pk) }}" data-title="<i class='fa fa-prescription'></i> Prescription of <strong>{{ $row->patient_name }}</strong>" title="View Prescription" data-modal="common-modal-md"><i class="fa fa-prescription"></i> View Prescription</span>

                                        <a href="{{ route('prescription-print-pdf',$row->prescription_no_pk) }}" class="badge badge-md badge-primary p-1 mb-1 cursor-pointer" target="_blank" data-id="{{ $row->prescription_no_pk }}"  title="Print Prescription"><i class="fas fa-print"></i> Print</a>
                                        @endif
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                <div class="alert alert-info" role="alert">
                    No Appointment Found
                </div>
            </div>
            @endif
        </div>
    </div>