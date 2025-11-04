@if (!empty($attend_data))
@foreach ($attend_data as $attData)
@php
    $edit_color = $attData->req_date!="" ? 'bg-warning':'';
@endphp

<tr class="<?php echo $edit_color ?>">
    <td class="text-center">{{ $attData->att_date ? date('d/m/Y', strtotime($attData->att_date)) : '' }}</td>
    <td class="text-center">{{ $attData->in_time ? date('H:i:s', strtotime($attData->in_time)) : '' }}</td>
    <td class="text-center">{{ $attData->out_time ? date('H:i:s', strtotime($attData->out_time)) : '' }}</td>
    <td class="text-center">
    @if ($attData->level_status_text == "Approved")
        <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.hrm.approval-level-tracking', $attData->requsition_no_pk) }}" data-id="{{ $attData->requsition_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">
        <strong class="text-success">APPROVED</strong>
        </a>
    @elseif ($attData->level_status_text == "Rejected")
       <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.hrm.approval-level-tracking', $attData->requsition_no_pk) }}" data-id="{{ $attData->requsition_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">
        <strong class="text-danger">REJECTED</strong>
       </a>
    @elseif ($attData->requsition_no_pk != null && $attData->level_status_text == 'Pending')
       <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.hrm.approval-level-tracking', $attData->requsition_no_pk) }}" data-id="{{ $attData->requsition_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">
       <strong>PENDING</strong>
       </a>
    @endif
    
    </td>
    <td class="text-center">
        @if ($attData->level_status_text == "Approved" || $attData->level_status_text == "Rejected")
        @else
        <a class="btn mb-1 btn-info btn-sm open-modal" data-modal="common-modal-md" data-action="{{ route('v1.hrm.edit_my_attendance', [$attData->att_date.'*'.$attData->in_time.'*'.$attData->out_time.'*'.$attData->requsition_no_pk]) }}" data-title="Edit Attendance">Edit</a>
        @endif
    </td>
</tr> 
@endforeach
@endif 