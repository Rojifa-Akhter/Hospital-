@if (!empty($manual_attendance_data))
@foreach ($manual_attendance_data as $ManuattData)
<tr>
    <td class="text-center">{{ $ManuattData->attendance_date ? date('d/m/Y', strtotime($ManuattData->attendance_date)) : '' }}</td>
    <td class="text-center">{{ $ManuattData->in_time ? date('H:i:s', strtotime($ManuattData->in_time)) : '' }}</td>
    <td class="text-center">{{ $ManuattData->out_time ? date('H:i:s', strtotime($ManuattData->out_time)) : '' }}</td>
    <td class="text-center">{{ $ManuattData->remarks ? $ManuattData->remarks  : '' }}</td>
    <td class="text-center">
        @if ($ManuattData->app_status == 1)
         <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.hrm.approval-level-tracking', $ManuattData->requsition_no_pk) }}" data-id="{{ $ManuattData->requsition_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">
            <strong class="text-success">APPROVED</strong>
         </a>
        @elseif ($ManuattData->app_status == 2)
        <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.hrm.approval-level-tracking', $ManuattData->requsition_no_pk) }}" data-id="{{ $ManuattData->requsition_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">
            <strong class="text-danger">REJECTED</strong>
            </a>
        @else
        <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.hrm.approval-level-tracking', $ManuattData->requsition_no_pk) }}" data-id="{{ $ManuattData->requsition_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">
            <strong class="">PENDING</strong>
            </a>
        @endif
    </td>
    <td class="text-center">
    @if ($ManuattData->app_status != 1 && $ManuattData->app_status != 2)
    <a class="btn mb-1 btn-info btn-sm open-modal" data-modal="common-modal-md" data-action="{{ route('v1.hrm.edit_manual_attendancev1', [$ManuattData->attendance_date.'*'.$ManuattData->in_time.'*'.$ManuattData->out_time.'*'.$ManuattData->requsition_no_pk]) }}" data-title="Edit Manual Attendance">Edit</a>
    @else
        {{ '' }}
    @endif
    </td>
</tr> 
@endforeach
@endif