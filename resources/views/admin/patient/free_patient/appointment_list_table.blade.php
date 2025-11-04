@if (!empty($appointment_rs))
    @foreach ($appointment_rs as $row)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">
                {{ $row->appoint_code }} <br>
                {{ $row->appoint_type_code == "REPORT" ? " App. Type = Report":'' }}
                {{ $row->free_pat_ind == 1 ? " App. Type = Free" :'' }}

            </td>
            <td class="text-center">{{ date('d/m/Y', strtotime($row->appoint_date)) }}</td>
            <td class="text-left">
                <div class="doctor_info">
                    <span Class="open-modal" data-id="{{ $row->doctor_no_fk }}"
                        data-action="{{ route('doctor.show', $row->doctor_no_fk) }}" data-modal="common-modal"
                        data-title="View Doctor Information" title="View Patient Information">
                        @if ($row->doctor_photo != '')
                            <img class="rounded"
                                src="{{ asset('images/uploads/doctor_images/thumb/' . $row->doctor_photo) }}">
                        @else
                            @if ($row->doc_gender_txt == 'Male')
                                <img class="rounded" src="{{ asset('images/doc-1.png') }}">
                            @else
                                <img class="rounded" src="{{ asset('images/nurse-2.png') }}">
                            @endif
                        @endif
                        <div class="doctor_info_data">
                            <ul style="list-style: none;">
                                <li class="cursor-pointer"><u><strong>{{ $row->person_code }}</strong></u></li>
                                <li class="cursor-pointer"><u>{{ $row->full_name }}</u></li>
                                <li>
                                    <small>
                                        @php
                                            $doctor_degree = rtrim(($row->degree1 != '' ? $row->degree1 . ',' : '') . ' ' . ($row->degree2 != '' ? $row->degree2 . ',' : '') . ' ' . ($row->degree3 != '' ? $row->degree3 . ',' : '') . ' ' . ($row->degree4 != '' ? $row->degree4 . ',' : ''), ', ');
                                        @endphp

                                        {{ $doctor_degree }}
                                    </small>
                                </li>
                                <li><i>{{ $row->specialization }},</i> {{ $row->phone_mobile }}</li>
                            </ul>
                        </div>
                    </span>
                </div>
            </td>
            <td class="text-left" style="vertical-align: top !important;">
                <div class="doctor_info">
                    <span Class="open-modal" data-id="{{ $row->patient_no_pk }}"
                        data-action="{registration.show{ route('', $row->patient_no_pk) }}" data-modal="common-modal"
                        data-title="View Patient Information" title="View Patient Information">
                        @if ($row->patient_photo != '')
                            <img class="rounded"
                                src="{{ asset('images/uploads/patient_images/thumb/' . $row->patient_photo) }}">
                        @else
                            @if ($row->gender_txt == 'Male')
                                <img class="rounded" src="{{ asset('images/pt-patient.png') }}">
                            @else
                                <img class="rounded" src="{{ asset('images/female.jpg') }}">
                            @endif
                        @endif
                        <div class="doctor_info_data">
                            <ul style="list-style: none;">
                                <li class="cursor-pointer"><u><strong>{{ $row->patient_code }} </strong></u></li>
                                <li class="cursor-pointer"><u>{{ $row->patient_name }}</u></li>
                                <li>{{ $row->gender_txt }}, {{ $row->mobile1 }}</li>
                            </ul>
                        </div>
                    </span>
                </div>
            </td>
            {{-- <td>{{ $row->chif_complain }}</td>
            <td>{{ $row->priority }}</td> --}}

            <td>{{ $row->patient_type_code }}</td>
            <td>

                @if ($row->appoint_no_pk == $row->appoint_service_no_fk && $row->cancel_ind == 0)
                    <span class="badge badge-success">Payment</span>
                @endif

                @if ($row->cancel_ind == 0 && $row->appoint_service_no_fk == '')
                    <span class="badge badge-warning">Pending</span>
                @endif

                @if ($row->cancel_ind == 1)
                    <span class="badge badge-danger" title="">Canceled</span>
                @endif
            </td>
            <td class="text-left bg-light" style="padding: 5px 10px !important;">

                <div>
                    <span class="badge badge-md badge-success open-modal p-1 mb-1 cursor-pointer"
                        data-id="{{ $row->appoint_no_pk }}"
                        data-action="{{ route('appointment-card-pat', $row->appoint_no_pk) }}"
                        data-title="Appointment card" title="Appointment card" data-modal="common-modal-sm"><i
                            class="fa fa-credit-card"></i> App. card</span>
                    @if ($row->cancel_ind == 0 )
                    {{-- && $row->consult_ind == 0 --}}
                        <span class="badge badge-md badge-danger p-1 mb-1 cursor-pointer open-modal"
                            data-id="{{ $row->appoint_no_pk }}"
                            data-action="{{ route('cancel-appointment-form', $row->appoint_no_pk) }}"
                            data-modal="common-modal-sm" data-title="Cancel Appointment Form"
                            title="Cancel this appointment"><i class="oi oi-circle-x"></i> Cancel</span>

                        <span class="badge badge-md badge-primary p-1 mb-1 cursor-pointer open-modal" data-id=""
                            data-action="{{ route('change-appointment-date', $row->appoint_no_pk) }}"
                            data-modal="common-modal-sm" data-title="Change Date And Time"
                            title="Change Date and Time"><i class="oi oi-calendar"></i> Change Date / Time</span>
                    @endif
                </div>

                @if ($row->cancel_ind == 0)
                    <div>
                        @if ($row->consult_ind == 1)
                            <span class="badge badge-sm badge-secondary cursor-pointer open-modal p-1 cursor-pointer"
                                data-id="{{ $row->invoice_no_pk }}"
                                data-action="{{ route('bill-invoice-app', $row->invoice_no_pk) }}"
                                data-title="Appointment Consultation Invoice"
                                title="View Appointment Consultation Invoice" data-modal="common-modal-md"><i
                                    class="fa fa-file-invoice-dollar"></i> Invoice</span>

                            <!--  <a href="{{ route('billing_appointment_invoice_pdf', $row->appoint_no_pk) }}" target="_blank"Class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" title="Print Appointment Consultation Invoice"><i class="fa fa-print"></i> Print</a> -->
                        @else

                            <a href="{{ route('billing.service-billing', $row->patient_no_pk . '-' . $row->appoint_no_pk . '-' . 'app') }}"
                                class="badge badge-md badge-primary p-1 mb-1 cursor-pointer" target="_blank"
                                title="Billing Entry"><i class="fas fa-file-invoice"></i> Billing</a>

                            <!--  @php
                                $action_url = route('appointments.appointment_consulation_confirm', $row->appoint_no_pk);
                                $response_url = route('bill-invoice-appointment', $row->appoint_no_pk);
                            @endphp
                            <span class="badge badge-md badge-secondary p-1 mb-1 cursor-pointer" data-action="{{ $action_url }}" id="btnConsulationConfirm" data-response-action="{{ $response_url }}" title="Appointment Consultation Bill" ><i class="fa fa-dollar-sign"></i> Pay Consultation Bill</span> -->
                        @endif
                    </div>

                    <div>

                        {{-- @if ($row->physio_ind == 1)
                            <a class="badge badge-md badge-info text-white open-modal p-1 mb-1 cursor-pointer"
                                href="{{ route('prescription-entry', [$row->appoint_no_pk, $row->patient_no_pk]) }}"
                                rel="tab"><i class="fa fa-prescription"></i> Prescription</a>
                        @else
                            <a class="badge badge-md badge-info text-white open-modal p-1 mb-1 cursor-pointer"
                                href="{{ route('prescription.create') }}" rel="tab"><i
                                    class="fa fa-prescription"></i> Prescription</a>
                        @endif --}}

                        @if ($row->prescription_no_pk != '')
                            <span class="badge badge-md badge-info text-white open-modal p-1 mb-1 cursor-pointer"
                                data-action="{{ route('opd_prescription_print', $row->prescription_no_pk) }}"
                                data-title="Create Prescription" title="View Prescription"
                                data-modal="common-modal-md"><i class="fa fa-prescription"></i> View Prescription</span>

                            <a href="{{ route('opd_prescription_print_pdf', $row->prescription_no_pk) }}"
                                class="badge badge-md badge-primary p-1 mb-1 cursor-pointer" target="_blank"
                                data-id="{{ $row->prescription_no_pk }}" title="Print Prescription"><i
                                    class="fas fa-print"></i> Print</a>
                        @endif

                        @if ($row->cancel_ind == 0)

                            <a href="{{ route('blank-prescription-form', $row->appoint_no_pk) }}"
                                class="badge badge-md badge-primary p-1 mb-1 cursor-pointer" target="_blank"
                                data-id="{{ $row->prescription_no_pk }}" title="Print Prescription"><i
                                    class="fa fa-prescription"></i> Blank Prescription Print</a>


                        @endif

                    </div>
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="9" class="text-center text-success"><span>No Data Found</span></td>
    </tr>
@endif
