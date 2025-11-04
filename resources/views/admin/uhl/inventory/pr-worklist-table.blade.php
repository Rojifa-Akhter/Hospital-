<table
class="table table-bordered table-hover table-striped">
<thead class="global-uhl-table-bg">
    <tr>
        <th>SL</th>
        <th>P.R No</th>
        <th class="text-left">P.R Date</th>
        <th class="text-left">Main Store</th>
        <th class="text-left">Req. By</th>
        <th class="text-left">Direct PR Remarks</th>
        <th>Approval Status</th>
        <th>Last Approved Date</th>
        <th>Status</th>
        <th>Indent Remarks</th>
        <th>No of Item</th>
        <th>No of Assign Item</th>
        <th style="width:10%">Action</th>
    </tr>

</thead>
<tbody>

    @if (!empty($requisition_list))
        {{-- @dd($requisition_list) --}}
        @foreach ($requisition_list as $row)
            {{-- @dd($row['multiple_remarks']) --}}
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-center">
                    {{ $row['inv_requisition_po_no_pk'] }}</td>
                <td>{{ $row['req_at'] != '' ? date('d-m-Y h:i:s a', strtotime($row['req_at'])) : '' }}
                </td>
                <td>{{ $row['serviceunit_name'] }}</td>
                <td>{{ $row['user_fullname'] }}</td>
                <td>{{ $row['req_po_remarks'] }}</td>
                <td class="text-center">
                    @if (strpos($row['approval_status_text'], 'REJECTED') >= 1 || strpos($row['approval_status_text'], 'HOLD') >= 1)
                        <a style="cursor:pointer"
                            class="open-modal"
                            data-action="{{ route('v1.my.approval.level.detail-pr-list', [$row['inv_requisition_po_no_pk'],'PR']) }}"
                            data-id="{{ $row['inv_requisition_po_no_pk'] }}"
                            data-modal="common-modal-sm"
                            data-title="Level Detail"
                            title="Level Detail">
                            <span
                                class="badge badge-warning">({{ $row['approval_level_status_text'] }})</span>
                        </a>
                        <span
                            class="text-danger">{{ strpos($row['approval_status_text'], 'HOLD') >= 1 ? 'Hold' : 'Rejected' }}</span>
                    @else
                        @if ($row['approval_level_status_text'] != '')
                            @php
                                $lavel = explode('/', $row['approval_level_status_text']);
                                $approval_status = $lavel[0] == $lavel[1] ? 'Approved' : 'Pending';
                                $approval_person = $row['approval_level_status_text'] != '' ? explode('/', $row['approval_level_status_text']) : '';

                            @endphp
                            @if (!empty($approval_person) && $approval_person[0] == $approval_person[1])
                                <a style="cursor:pointer"
                                    class="open-modal"
                                    data-action="{{ route('v1.my.approval.level.detail-pr-list', [$row['inv_requisition_po_no_pk'],'PR']) }}"
                                    data-id="{{ $row['inv_requisition_po_no_pk'] }}"
                                    data-modal="common-modal-sm"
                                    data-title="Level Detail"
                                    title="Level Detail">
                                    <span
                                        class="badge badge-success">({{ $row['approval_level_status_text'] }})
                                    </span>
                                </a>
                            @else
                                <a style="cursor:pointer"
                                    class="open-modal"
                                    data-action="{{ route('v1.my.approval.level.detail-pr-list', [$row['inv_requisition_po_no_pk'],'PR']) }}"
                                    data-id="{{ $row['inv_requisition_po_no_pk'] }}"
                                    data-modal="common-modal-sm"
                                    data-title="Level Detail"
                                    title="Level Detail" >
                                    <span
                                        class="badge badge-warning">({{ $row['approval_level_status_text'] }})</span>
                                </a>
                            @endif
                            {{ $approval_status }}
                        @endif
                    @endif
                </td>
                <td>  {{ $row['app_date'] !="" ? date('d/m/Y',strtotime($row['app_date'])) :'' }}</td>
                <td class="text-center">
                    {{ $row['req_po_save_option'] }}</td>

                {{-- @if (!empty($row['multiple_remarks']))
                    @foreach ($row['multiple_remarks'] as $ind_remarks)
                        <td class="text-center">
                            {{ $ind_remarks }}</td>
                    @endforeach
                @endif --}}
                <td class="text-center">
                    {{ $row['multiple_remarks'] }}</td>
                <td class="text-center"> {{ $row['item_count'] }}
                </td>
                <td class="text-center"> {{ $row['assign_count'] }}
                </td>
                <td>
                    <!-- ||  $row['app_status'] ==1 -->
                    {{-- || $row['req_po_save_option'] == 'POST' --}}
                    @if ($row['req_po_save_option'] == 'DRAFT' )
                        @if (strpos($row['approval_status_text'], 'REJECTED') >= 1 || strpos($row['approval_status_text'], 'HOLD') >= 1 )

                        @else
                            <a href="{{ route('v1.direct-pr-edit', [$row['inv_requisition_po_no_pk'], $row['app_status']]) }} "
                               
                                class="btn btn-sm btn-primary" target="_blank"><i
                                    class="far fa-edit"></i></a>
                        @endif
                    @endif
                    @if(Session::get('user.ses_hospital_code') === 'IMPERIAL')
                        <a href="{{ route('v1.pr-print-imperial', $row['inv_requisition_po_no_pk']) }}" title="PR Report (Imperial)" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-print"></i>
                        </a>
                    @else
                        <a href="{{ route('v1.pr-print', $row['inv_requisition_po_no_pk']) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-print"></i>
                        </a>
                    @endif
                    <a href="{{ route('v1.pr-excel', $row['inv_requisition_po_no_pk']) }}"
                        target="_blank"
                        class="btn btn-sm btn-primary"><i class="fa fa-file-excel"></i></a>
                    @if (!empty($row['pr_doc_attachment_path']))
                        <a href="{{ asset('images/uploads/attachment/' . $row['pr_doc_attachment_path']) }}"
                            target="_blank"
                            class="btn btn-sm btn-success"><i
                                class="fas fa-file"></i></a>
                    @endif

                    <span class="btn btn-success btn-sm open-modal btnView"
                    data-action="{{ route('v1.pr_view_popup', $row['inv_requisition_po_no_pk']) }}"
                    data-modal="common-modal-md" data-title="Requisition Items" title="View Requisition Items"
                    data-id="{{ $row['inv_requisition_po_no_pk']}}"><i
                    class="fa fa-eye"></i></span>
                    
                    <span class="btn btn-warning btn-sm open-modal btnView"
                    data-action="{{ route('v1.pr_currency_change', $row['inv_requisition_po_no_pk']) }}"
                    data-modal="common-modal-sm" data-title="Currency Update" title="Currency Update"
                    data-id="{{ $row['inv_requisition_po_no_pk']}}"> <i class="fas fa-money-bill-alt"></i></span>
                   
                </td>
            </tr>
        @endforeach
    @endif

</tbody>
</table>
