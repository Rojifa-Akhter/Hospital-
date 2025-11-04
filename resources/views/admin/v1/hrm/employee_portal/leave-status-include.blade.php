<div id="leave_app" class="collapse p-1" aria-labelledby="headingThree" data-parent="#accordion">
<div class="row">
    <div class="col-md-12">
        <div class="card-body">
            <div class="table-responsive">
                <table id="leave_status_include" class="table table-striped table-bordered table-hover data-table">
                    <thead class="global-uhl-table-bg">
                        <tr>
                            <th>SL</th>
                            <th>Leave Type</th>
                            <th>Leave Reason</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Status</th>
                            <th>Attachment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($leave_data))
                        {{-- @dd($leave_data) --}}
                            @foreach ($leave_data as $datas)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $datas->leave_type_name }}
                                    </td>
                                    <td>{{ $datas->leave_reason }}
                                    </td>
                                    <td>{{ $datas->from_date ? date('d/m/Y', strtotime($datas->from_date)) : '' }}
                                    </td>
                                    <td>{{ $datas->to_dates ? date('d/m/Y', strtotime($datas->to_dates)) : '' }}
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $status = 'Approval Not Found';
                                            $approval_exp = $datas->approval_level_status_text != '' ? explode('/', $datas->approval_level_status_text) : '';
                                            $status_pending = strpos($datas->approval_status_text, 'PENDING') >= 1;
                                    
                                            if (strpos($datas->approval_status_text, 'APPROVED') >= 1) {
                                                $status = 'APPROVED';
                                            }
                                            if (strpos($datas->approval_status_text, 'PENDING') >= 1) {
                                                $status = 'PENDING';
                                            }
                                            if (strpos($datas->approval_status_text, 'REJECTED') >= 1) {
                                                $status = 'REJECTED';
                                            }
                                            if (strpos($datas->approval_status_text, 'HOLD') >= 1) {
                                                $status = 'HOLD';
                                            }
                                        @endphp
                                        @if ($datas->manual_lv_ind == 1)
                                            <strong>{{ 'ENTRY BY HR' }}</strong>
                                        @else
                                        <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.hrm.approval-level-tracking-leave-application', $datas->leave_no_pk) }}" data-id="{{ $datas->leave_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">
                                            <strong>{{ $status }}</strong>
                                        </a>
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if(!empty($datas->leave_attch))
                                        <a href="{{asset('uploads/leave_file/'.$datas->leave_attch)}}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file"></i></a>
                                        @endif
                                    </td>
                                    <td>
                                    @if ($status != 'REJECTED' && $status != 'APPROVED' && $datas->manual_lv_ind != 1)
                                        <button
                                            class="btn btn-sm btn-primary open-modal"
                                            data-modal="common-modal-sm"
                                            data-action="{{ route('v1.hrm.leave-edit', $datas->leave_no_pk) }}"
                                            data-title="Edit Leave Data"
                                            title="Edit"><i class="fa fa-pencil-alt"></i></button>
                                        <span href="#" class="btn btn-sm btn-danger"
                                            onclick="deleteLeaveApplication({{ $datas->leave_no_pk }})"><i class="fa fa-trash" aria-hidden="true"></i></span>
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>