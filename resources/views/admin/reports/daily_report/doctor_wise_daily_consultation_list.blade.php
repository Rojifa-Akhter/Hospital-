@php
$total_no_of_appointment = $total_consultation_amt = 0;
@endphp
@if (!empty($doctorWiseDailyConsultation))

@foreach ($doctorWiseDailyConsultation as $value)
@php
$appointment_parameter_new = $value->appoint_date."_".$value->doctor_no_fk;
@endphp
<tr>

    <td class="text-center" scope="col">{{$loop->iteration}}</td>
    <td class="text-center" scope="col">{{ date("d/m/Y", strtotime($value->appoint_date))}}</td>
    <td class="text-left" scope="col">{{$value->doctor_name}}</td>
    <td class="text-center" scope="col">
        <a class="float-center open-modal" data-modal="common-modal-md"
            data-action="{{ route('report.doctor-wise-daily-consultation-popup',$appointment_parameter_new) }}"
            data-title="Total New Appointment">{{($value->total_appointment)}}</a>

    </td>
    <td class="text-right" scope="col">{{ number_format($value->amount,2)}}</td>

</tr>
@php
$total_no_of_appointment += $value->total_appointment;
$total_consultation_amt += $value->amount;
@endphp
@endforeach
@endif
<tr>
    <td></td>
    <td></td>
    <td class="text-right">Total = </td>
    <td class="text-center"><strong>{{ $total_no_of_appointment }}</strong></td>
    <td class="text-right"><strong>{{ number_format($total_consultation_amt,2)}}</strong></td>
</tr>