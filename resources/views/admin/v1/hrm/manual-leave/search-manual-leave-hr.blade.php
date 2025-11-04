@if (!empty($manual_leave_data))
@foreach ($manual_leave_data as $data)
<tr>
<td class="text-center">{{ $loop->iteration }}</td>
<td class="text-left">{{ $data->full_name }}</td>
<td>{{ $data->leave_type_name }}</td>
<td>{{ $data->leave_reason }}</td>
<td class="text-center">{{ $data->from_date ? date('d-m-Y', strtotime($data->from_date)) : '' }}</td>
<td class="text-center">{{ $data->to_dates ? date('d-m-Y', strtotime($data->to_dates)) : '' }}</td>
<td class="text-center">
    <button class="btn btn-sm btn-primary open-modal" data-modal="common-modal-sm"
    data-action="{{ route('v1.hrm.manual-leave-edit', $data->leave_no_pk) }}"
    data-title="Edit Leave Data" title="Edit"><i class="fa fa-pencil-alt"></i>
</button>
{{-- <span href="#" class="btn btn-sm btn-danger"
onclick="deleteLeaveApplication({{ $data->leave_no_pk }})"><i class="fa fa-trash" aria-hidden="true"></i> --}}
</span>
</td>
</tr>
@endforeach
@endif