@if (!empty($datas))
@foreach ($datas as $data)
<tr>
    <td class="text-center">{{ $loop->iteration }}</td>
    <td class="text-left">{{ $data->full_name }}</td>
    <td class="text-center">{{ $data->card_no }}</td>
    <td class="text-center">{{ $data->serviceunit_name }}</td>
    <td class="text-left">{{ $data->designation_name }}</td>
    <td class="text-left">{{ $data->leave_type_lkp_name }}</td>
    <td class="text-left">{{ $data->leave_reason }}</td>
    <td class="text-center">{{ $data->from_date ? date('d/m/Y', strtotime($data->from_date)) : '' }}</td>
    <td class="text-center">{{ $data->to_dates ? date('d/m/Y', strtotime($data->to_dates)) : '' }}</td>
</tr>
@endforeach
@endif