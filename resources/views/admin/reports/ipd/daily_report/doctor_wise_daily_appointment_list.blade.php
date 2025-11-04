@if(!empty($value))
    @foreach($value as $row)
        @php
            $appointment_parameter_new = $row->appoint_date."_".$row->doctor_no_fk."_NEWCONS";
        $appointment_parameter_followup = $row->appoint_date."_".$row->doctor_no_fk."_FOLLOWUP";
        @endphp
        <tr>
            <td class="text-center">{{ date("d/m/Y",strtotime($row->appoint_date))}}</td>
            <td class="text-left">{{ $row->doctor_name}}</td>
            <td class="text-center"><a class="float-center open-modal"
                                       data-modal="common-modal-md"

                                       data-action="{{ route('report.doctor-wise-daily-appointment-popup',$appointment_parameter_new) }}"
                                       data-title="Total New Appointment"> {{ $row->total_new}} </a>
            </td>
            <td class="text-center"><a class="float-center open-modal"
                                       data-modal="common-modal-md"
                                       data-action="{{ route('report.doctor-wise-daily-appointment-popup', $appointment_parameter_followup) }}"
                                       data-title="Total FollowUp Appointment"> {{ $row->total_followup}} </a>
            </td>
        </tr>
    @endforeach @endif

