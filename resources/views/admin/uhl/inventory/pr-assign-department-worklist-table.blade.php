<table
class="table table-bordered table-hover table-striped">
<thead class="global-uhl-table-bg">
    <tr>
        <th>SL</th>
        <th  class="text-left">Assign Employee Name</th>
        <th>P.R No</th>
        <th class="text-left">P.R Date</th>
        <th class="text-left">Item Name</th>
        <th class="text-left">Qty</th>
        <th class="text-left">Uom</th>
        <th class="text-left">Main Store</th>
        <th>Approval Status</th>
        <th>Status</th>
        <th style="width:10%">Action</th>
    </tr>

</thead>
<tbody>

    @if (!empty($requisition_list))
       
        @foreach ($requisition_list as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-left">
                    {{ $row['assign_by_name'] }}
                </td>
                <td class="text-center">
                    {{ $row['inv_requisition_po_no_pk'] }}
                </td>
                
                <td>{{ $row['req_at'] != '' ? date('d-m-Y h:i:s a', strtotime($row['req_at'])) : '' }}
                </td>
                <td class="text-center">
                    {{ $row['item_name'] }}
                </td><td class="text-center">
                    {{ $row['req_quantity'] }}
                </td><td class="text-center">
                    {{ $row['item_pur_uom_name'] }}
                </td>
                <td>{{ $row['serviceunit_name'] }}</td>
                <td class="text-center">
                    @if (strpos($row['approval_status_text'], 'REJECTED') >= 1 || strpos($row['approval_status_text'], 'HOLD') >= 1)
                        <a style="cursor:pointer"
                            class="open-modal"
                            data-action="{{ route('v1.my.approval.level.detail-pr-list', $row['inv_requisition_po_no_pk']) }}"
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
                                    data-action="{{ route('v1.my.approval.level.detail-pr-list', $row['inv_requisition_po_no_pk']) }}"
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
                                    data-action="{{ route('v1.my.approval.level.detail-pr-list', $row['inv_requisition_po_no_pk']) }}"
                                    data-id="{{ $row['inv_requisition_po_no_pk'] }}"
                                    data-modal="common-modal-sm"
                                    data-title="Level Detail"
                                    title="Level Detail">
                                    <span
                                        class="badge badge-warning">({{ $row['approval_level_status_text'] }})</span>
                                </a>
                            @endif
                            {{ $approval_status }}
                        @endif
                    @endif
                </td>
                <td class="text-center">
                    {{ $row['assign_ind'] ==1 ? 'Assigned' : 'Pending' }}
                </td>
                <td>   
                    @if($row['assign_ind'] ==1  )                
                    <button class="btn btn-sm btn-danger" data-prDtlNo="{{$row['inv_requisition_po_no_pk']}}"  data-item_no="{{$row['item_no_fk']}}" onclick="clearAssign(this)">Clear Assaign</a>   
                    @endif  
                </td>
            </tr>
        @endforeach
    @endif

</tbody>
</table>
