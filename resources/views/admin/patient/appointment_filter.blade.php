
    @if(!empty($appointment_rs))
    @foreach($appointment_rs as $row)
    <tr>
        <td class="text-center">{{ $row->slot_sl }}</td>
        <td class="text-center">{{ $row->appoint_code }}</td>
        <td class="text-center">{{ date("d-m-Y", strtotime($row->appoint_date)) }}</td>
        <td class="text-left">
            <div class="doctor_info">
                <img src="{{asset ('images/doctor.png')}}" alt="doctor image" class="rounded">
                <div class="doctor_info_data">
                    <ul>
                        <li>{{ $row->full_name }}</li>
                        <li><i>{{ $row->specialization }},</i> <strong>Ph :</strong> {{ $row->phone_mobile }}</li>
                    </ul>
                </div>
            </div>
        </td>
        <td class="text-left">
            <div class="doctor_info">
                <img src="{{asset ('images/doctor.png')}}" alt="doctor image" class="rounded">
                <div class="doctor_info_data">
                    <ul>
                        <li><strong>{{ $row->patient_code }} :</strong> {{ $row->patient_name }}</li>
                        <li><strong>G: </strong>{{ $row->gender_txt }}, <strong>Ph: </strong>{{ $row->mobile1 }}</li>
                    </ul>
                </div>
            </div>
        </td>
        <td>{{ $row->chif_complain }}</td>
        <td></td>
        <td>{{ $row->priority }}</td>
        <td class="text-center">
            <span class="btn btn-sm btn-danger" data-id="{{ $row->appoint_no_pk }}" onclick="removeById(this)" data-url="{{ route('delete-appointment-by-id', $row->appoint_no_pk) }}" title="Cancel this appointment"><i class="oi oi-circle-x"></i></span>
            <span class="btn btn-sm btn-success" title="Appointment Consultation Fee"><i class="fa fa-credit-card"></i></span>
        </td>
    </tr>
    @endforeach
    @endif