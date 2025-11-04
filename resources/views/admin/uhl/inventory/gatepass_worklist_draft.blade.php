<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th>SL#</th>
                <th class="text-left">Department</th>
                <th>GID</th>
                {{-- <th>Gate Pass Serial No</th> --}}
                <th class="text-left">Date</th>
                <th class="text-left">Issue To</th>
                <th class="text-left">Issue Date</th>
                <th class="text-left">Return Date</th>
                <th class="text-left">Purpose/ Problem</th>
                <th class="text-left">Supplier Name</th>
                <th>Returnable</th>
                <th>Onetime</th>
                <th>No Of Item</th>
                <th>Status</th>
                <th>Approval Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @if (!empty($getapassMstDraft))
                @foreach ($getapassMstDraft as $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left">{{ isset($value->department) ? $value->department : '' }}</td>
                        <td class="text-center">{{ $value->gatepass_uid }}</td>
                        {{-- <td class="text-center">{{ $value->sl_no }}</td> --}}
                        <td>{{ $value->gatepass_date != '' ? date('d/m/Y', strtotime($value->gatepass_date)) : '' }}
                        </td>
                        <td>{{ $value->issued_to_name }}</td>
                        <td>{{ $value->issue_date != '' ? date('d/m/Y', strtotime($value->issue_date)) : '' }}</td>
                        <td>{{ $value->return_date != '' ? date('d/m/Y', strtotime($value->return_date)) : '' }}</td>
                        <td>{{ $value->gatepass_purpose_short }}</td>
                        <td>{{ $value->vendor_supplier_name }}</td>
                        <td class="text-center">
                            @if ($value->returnable_ind == 1)
                                <i class="fas fa-check"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($value->onetime_use_ind == 1)
                                <i class="fas fa-check"></i>
                            @endif
                        </td>
                        <td class="text-center">{{ $value->item_count }} </td>
                        <td class="text-center">{{ $value->gatepass_save_option }} </td>
                        <td class="text-center">
                            @php
                                $status = 'Approval Not Found';
                                $approval_exp = $value->approval_level_status_text != '' ? explode('/', $value->approval_level_status_text) : '';
                                $status_pending = strpos($value->approval_status_text, 'PENDING') >= 1;
                                
                                if (strpos($value->approval_status_text, 'APPROVED') >= 1) {
                                    $status = 'APPROVED';
                                }
                                if (strpos($value->approval_status_text, 'PENDING') >= 1) {
                                    $status = 'PENDING';
                                }
                                if (strpos($value->approval_status_text, 'REJECTED') >= 1) {
                                    $status = 'REJECTED';
                                }
                                if (strpos($value->approval_status_text, 'HOLD') >= 1) {
                                    $status = 'HOLD';
                                }
                                
                            @endphp
                            {{ $status }}
                            {{-- @if ($approval_exp != '' && $approval_exp[0] == $approval_exp[1])
                                Approved
                            @elseif($approval_exp != '' && $approval_exp[0] != $approval_exp[1])
                                Pending
                            @endif --}}
                        </td>
                        <td>
                            {{-- <a href="{{ route('v1.gatepass-entry', $value->gatepass_no_pk) }}"
                                class="btn btn-sm btn-success" title="Edit" target="_blank"><i
                                    class="fas fa-edit"></i></a> --}}
                            @if ($approval_exp != '' && $approval_exp[0] == $approval_exp[1])
                                <a href="{{ route('v1.gatepass-worklist-print', $value->gatepass_no_pk) }}"
                                    target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
                            @else
                                <a href="{{ route('v1.gatepass-entry', $value->gatepass_no_pk) }}"
                                    class="btn btn-sm btn-success" title="Edit" target="_blank"><i
                                        class="fas fa-edit"></i></a>
                            @endif
                        </td>

                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
