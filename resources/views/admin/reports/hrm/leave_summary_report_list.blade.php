@if(isset($leave_summary))
@foreach($leave_summary as $data)
<tr>
    <td class="text-center" scope="col">{{$loop->iteration}}</td>
    <td class="text-left" scope="col">{{ $data->person_code }}</td>
    <td class="text-left" scope="col">{{ $data->full_name }}</td>
    <td class="text-left" scope="col">{{ $data->designation_name }}</td>
    <td class="text-left" scope="col">{{ $data->su_name }}</td>
    <td class="text-left" scope="col">{{ $data->leave_request }}</td>
    <td class="text-left" scope="col">{{ $data->available_leave }}</td>
    <td class="text-left" scope="col">{{ $data->approved_leave }}</td>
</tr>
@endforeach
@endif
