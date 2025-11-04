@if (!empty($pr_data_list) && count($pr_data_list) > 0)
    @foreach ($pr_data_list as $key => $val)
        <tr>
            <td scope="row">{{ $key + 1 }}</td>
            <td>
                <span class="target"> {{ $val->inv_requisition_po_no_pk }} </span>
            </td>
            <td>{{ isset($val->req_at) ? date('d/m/Y', strtotime($val->req_at)) : '' }}</td>
            <td>{{ $val->from_store }}</td>

            <td class="text-center">
                @if(strpos($val->approval_status_text, 'REJECTED') >= 1 || strpos($val->approval_status_text, 'HOLD') >= 1)
                    <a style="cursor:pointer" class="open-modal"
                        data-action="{{ route('v1.my.approval.level.detail-pr-list', $val->inv_requisition_po_no_pk) }}"
                        data-id="{{ $val->inv_requisition_po_no_pk }}" data-modal="common-modal-sm"
                        data-title="Level Detail" title="Level Detail">
                        <span class="badge badge-warning">({{ $val->approval_level_status_text }})</span>
                    </a>
                    <span class="text-danger">{{ strpos($val->approval_status_text, 'HOLD') >= 1 ? 'Hold' : 'Rejected' }}</span>
                @else
                    @if ($val->approval_level_status_text != '')
                        @php
                            $lavel = explode('/', $val->approval_level_status_text);
                            $approval_status = $lavel[0] == $lavel[1] ? 'Approved' : 'Pending';
                            $approval_person = $val->approval_level_status_text != '' ? explode('/', $val->approval_level_status_text) : '';                           
                        @endphp
                        @if (!empty($approval_person) && $approval_person[0] == $approval_person[1])
                            <a style="cursor:pointer" class="open-modal"
                                data-action="{{ route('v1.my.approval.level.detail-pr-list', $val->inv_requisition_po_no_pk) }}"
                                data-id="{{ $val->inv_requisition_po_no_pk }}" data-modal="common-modal-sm"
                                data-title="Level Detail" title="Level Detail">
                                <span class="badge badge-success">({{ $val->approval_level_status_text }})
                                </span>
                            </a>
                        @else
                            <a style="cursor:pointer" class="open-modal"
                                data-action="{{ route('v1.my.approval.level.detail-pr-list', $val->inv_requisition_po_no_pk) }}"
                                data-id="{{ $val->inv_requisition_po_no_pk }}" data-modal="common-modal-sm"
                                data-title="Level Detail" title="Level Detail">
                                <span class="badge badge-warning">({{ $val->approval_level_status_text }})</span>
                            </a>
                        @endif
                        {{ $approval_status }}
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
@endif

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
	
    $(document).ready(function() {
        $('.target').click(function() {
            var result = $(this).closest('td').text();
            $('#pr_no').val(result.trim());
        });
    });
</script>
