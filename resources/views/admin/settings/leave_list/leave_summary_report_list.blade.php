@if(isset($leave_summary))
@foreach($leave_summary as $data)
<tr>
    <td class="text-center" scope="col">{{$loop->iteration}}</td>
    <td class="text-center" scope="col">{{ $data->person_code }}</td>
    <td class="text-center" scope="col">{{$data ? date('d/m/Y', strtotime($data->au_entry_at)) : '' }}</td>
    <td class="text-left" scope="col">{{ $data->full_name }}</td>
    <td class="text-center" scope="col">{{ $data->designation_name }}</td>
    <td class="text-center" scope="col">{{ $data->su_name }}</td>
    <td class="text-center" scope="col">{{ $data->from_date ? date('d/m/Y', strtotime($data->from_date)) : ''}}</td>
    <td class="text-center" scope="col">{{ $data->to_dates ? date('d/m/Y', strtotime($data->to_dates)) : ''}}</td>
    @php
        $day_diff = (strtotime($data->to_dates) - strtotime($data->from_date)) / (3600 * 24)+1;
    @endphp
    <td class="text-center" scope="col">{{ $day_diff }} {{ $day_diff == 1 || $day_diff == 0 ? 'Day' : 'Days' }}</td>
    <td class="text-center" scope="col">{{ $data->all_leave }} {{ $data->all_leave == 1 || $data->all_leave == 0 ? 'Day' : 'Days' }}</td>
    <td class="text-center" scope="col">{{ $data->ramaining_leave }} {{ $data->ramaining_leave == 1 || $data->ramaining_leave == 0 ? 'Day' : 'Days' }}</td>
    <td class="text-center" scope="col">{{($data->all_leave - $data->ramaining_leave) }} {{ ($data->all_leave - $data->ramaining_leave) == 1 || ($data->all_leave - $data->ramaining_leave) == 0 ? 'Day' : 'Days' }}</td>
</tr>
@endforeach
@endif
