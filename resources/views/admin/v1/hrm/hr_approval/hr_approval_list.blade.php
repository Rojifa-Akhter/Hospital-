<form action="{{ route('hrm.hr-leave-approve') }}" method="POST" id="hr_leave_approve" class="">
    <div class="col-md-12 text-right">
        @php
            $response_action = route('hrm.hr-approval');
        @endphp
        <input type="hidden" name="status" id="leave_status" value="">
        <button type="button" class="btn btn-md btn-outline-success mb-1 mt-1"
            onclick="submitLeaveApproval(this,'approve')">Approve</button>
        <button type="button" class="btn btn-md btn-danger mb-1 mt-1"
            onclick="submitLeaveApproval(this,'reject')">Reject</button>
        <button type="button" class="btn btn-md btn-warning mb-1 mt-1"
            onclick="submitLeaveApproval(this, 'hold')">Hold</button>
    </div>
    <table class="table table-striped table-bordered table-hover data-table">
        <thead class="thead-success">
            <tr>
                <th>SL#</th>
                <th class="text-left">Code</th>
                <th class="text-left">Employee Name</th>
                <th class="text-left">Department</th>
                <th class="text-left">Unit</th>
                <th class="text-left">Designation</th>
                <th class="text-left">Leave Type</th>
                <th class="text-left">From Date</th>
                <th class="text-left">To Date</th>
                <th class="text-left">No. of Days</th>
                <th class="text-left">Reason</th>
                <th class="text-left">Approval Detail</th>
                <th class="text-left">Action</th>
                <th class="text-center" style="width:3%"><input type="checkbox" id="PathselectAll" /></th>
            </tr>
        </thead>
        <tbody id="">
            @if (!empty($pendingLeavedata))
                @foreach ($pendingLeavedata as $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $data->card_no }}</td>
                        <td class="text-left">{{ $data->full_name }}</td>
                        <td class="text-left">{{ $data->department }}</td>
                        <td class="text-left">{{ $data->unit }}</td>
                        <td class="text-left">{{ $data->designation_name }}</td>
                        <td class="text-left">{{ $data->leave_type_name }}</td>
                        <td class="text-left">
                            @if (!empty($data->from_date))
                                {{ date('d/m/Y', strtotime($data->from_date)) }}
                            @endif
                        </td>
                        <td class="text-left">
                            @if (!empty($data->to_dates))
                                {{ date('d/m/Y', strtotime($data->to_dates)) }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if (!empty($data->from_date) && !empty($data->to_dates))
                                <?php
                                $date1 = new DateTime($data->from_date);
                                $date2 = new DateTime($data->to_dates);
                                $interval = $date1->diff($date2);
                                echo $interval->days + 1;
                                ?>
                            @endif
                        </td>
                        <td class="text-left">{{ $data->leave_reason }}</td>
                        <td class="text-left">
                            @inject('leave_approval_status', 'App\Http\Controllers\LeaveController')
                            @php
                                $approval_status = $leave_approval_status->check_leave_approval_status(
                                    $data->leave_no_pk,
                                );
                            @endphp
                            <a style="cursor:pointer" class="open-modal btn btn-success btn-sm"
                                data-action="{{ route('v1.my.approval.level.detail.hr', $approval_status['apprprocess_no_pk']) }}"
                                data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm"
                                data-title="Approval Level Detail" title="Show">Show
                            </a>
                        </td>
                        <td class="text-left">
                            <a href="{{ route('hrm.leave-detail', $data->person_no_fk) }}" class="btn btn-outline-primary btn-sm bg-none" target="_blank"  title="Detail">
                                Detail
                            </a>
                            {{-- @if ($approval_status['approval_status'] == 1 && $approval_status['hold_status'] == 0)
                                <button type="button" class="btn btn-md btn-outline-success mb-1 mt-1 open-modal"
                                    data-action="{{ route('v1.edit.my.approval.status', [
                                        $approval_status['apprprocess_no_pk'] . '*' . $approval_status['approval_for_code'],
                                        'hr_status',
                                    ]) }}"
                                    data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm"
                                    data-title="Approve" title="Approve">Approve</button>

                                <button type="button" class="btn btn-md btn-danger mb-1 mt-1 open-modal"
                                    data-action="{{ route('v1.reject.my.approval.status', [$approval_status['apprprocess_no_pk'], $approval_status['approval_for_code'], 'hr_status']) }}"
                                    data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm"
                                    data-title="Reject" title="Reject">Reject</button>

                                <button type="button" class="btn btn-md btn-warning mb-1 mt-1 open-modal"
                                    data-action="{{ route('v1.hold.my.approval.status', $approval_status['apprprocess_no_pk']) }}"
                                    data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm"
                                    data-title="Hold" title="Hold">Hold</button>
                            @elseif($approval_status['approval_status'] == 1 && $approval_status['hold_status'] == 1)
                                <button type="button" class="btn btn-md btn-warning mb-1 mt-1 open-modal"
                                    data-action="{{ route('v1.unHold.my.approval.status', $approval_status['apprprocess_no_pk']) }}"
                                    data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm"
                                    data-title="Unhold" title="Unhold">Unhold</button>
                            @endif --}}
                            @if ($approval_status['approval_status'] == 1 && $approval_status['hold_status'] == 0)
                                <button type="button" class="btn btn-md btn-outline-success mb-1 mt-1 open-modal"
                                    data-action="{{ route('v1.hr.edit.my.approval.status', [
                                        $approval_status['apprprocess_no_pk'] . '*' . $approval_status['approval_for_code'],
                                        'hr_status',
                                    ]) }}"
                                    data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm"
                                    data-title="Approve" title="Approve">Approve</button>

                                <button type="button" class="btn btn-md btn-danger mb-1 mt-1 open-modal"
                                    data-action="{{ route('v1.hr.reject.my.approval.status', [$approval_status['apprprocess_no_pk'], $approval_status['approval_for_code'], 'hr_status']) }}"
                                    data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm"
                                    data-title="Reject" title="Reject">Reject</button>

                                <button type="button" class="btn btn-md btn-warning mb-1 mt-1 open-modal"
                                    data-action="{{ route('v1.hr.hold.my.approval.status', $approval_status['apprprocess_no_pk']) }}"
                                    data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm"
                                    data-title="Hold" title="Hold">Hold</button>
                                @elseif($approval_status['approval_status'] == 1 && $approval_status['hold_status'] == 1)
                                <button type="button" class="btn btn-md btn-warning mb-1 mt-1 open-modal"
                                    data-action="{{ route('v1.hr.unHold.my.approval.status', $approval_status['apprprocess_no_pk']) }}"
                                    data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm"
                                    data-title="Unhold" title="Unhold">Unhold</button>
                                @endif 
                        </td>
                        <td class="text-center">
                            @if ($approval_status['approval_status'] == 1 && $approval_status['hold_status'] == 0)
                                <input type="checkbox" class="leave_pending" name="leave_pending[]" value="{{ $approval_status['apprprocess_no_pk'] }},{{ $approval_status['approval_for_code'] }}">
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</form>
@if (isset($status))
    <script>
        $('.data-table').DataTable({
            "ordering": true,
            "searching": true,
            "paging": false,
            "columnDefs": [{
                    "width": "280px",
                    "targets": 12
                },
                {
                    "orderable": false,
                    "targets": 13
                }
            ]
        });
    </script>
@endif
<script>
   function submitLeaveApproval(element, status) {
        var formElement = document.getElementById('hr_leave_approve');
        var formData = new FormData(formElement); 
        formData.append('status', status); 
        var url = $('#hr_leave_approve').attr('action');
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false, 
            contentType: false, 
            success: function(response) {
                $("#searchHrApproval").click();
                $('.exampleModal').modal('hide');
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                $('.common-modal-notify .modal-title').html(response.title);
                $('.common-modal-notify .modal-body').html(response.msg);
            },
            error: function(xhr) {
                alert('Error in data. Please try again.');
            }
        });
    }
    $('#PathselectAll').click(function(e) {
        if ($('#PathselectAll').is(':checked')) {
            $('.leave_pending').prop('checked', true);
        } else {
            $('.leave_pending').prop('checked', false);
        }
    });
</script>
