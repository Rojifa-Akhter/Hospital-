@if (!empty($balance_leave))
@foreach ($balance_leave as $data)
<tr>
    <td class="text-center">{{ $loop->iteration }}</td>
    <td class="text-left">{{ $data->full_name }}</td>
    <td class="text-center">{{ $data->card_no }}</td>
    <td class="text-left">{{ $data->designation_name }}</td>
    <td class="text-left">{{ $data->serviceunit_name }}</td>
    <td class="text-center">{{ $data->total_balance - $data->total_leave }}</td>
    <td class="text-center">
        <span Class="btn btn-sm open-modal" style="background-color: #770CCB"
        data-id="{{ $data->person_no_pk }}"
        data-action="{{ route('hr.show-leave-details-for-hr', $data->person_no_pk) }}" data-modal="common-modal-md"
        data-title="View Leave Details" title="View Leave Details"><i
        class="fa fa-eye text-white"></i></span>

        <span Class="btn btn-sm btn-success open-modal"
        data-id="{{ $data->person_no_pk }}"
        data-action="{{ route('hr.show-availed-leave-details', $data->person_no_pk) }}" data-modal="common-modal-md"
        data-title="View Availed Details" title="View Availed Details"><i
        class="fa fa-eye text-white"></i></span>
    </td>
</tr>
@endforeach
@endif
