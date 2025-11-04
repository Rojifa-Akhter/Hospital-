<form action="{{ route('hrm.hr-attendance-approve') }}" method="POST" id="hr_attendance_approve" class="">
    <div class="col-md-12 text-right">
        @php
            $response_action = route('hrm.hr-attendance-approval');
        @endphp
        <input type="hidden" name="status" id="leave_status" value="">
        <button type="button" class="btn btn-md btn-outline-success mb-1 mt-1"
            onclick="submitAttendanceApproval(this,'approve')">Approve</button>
        <button type="button" class="btn btn-md btn-danger mb-1 mt-1"
            onclick="submitAttendanceApproval(this,'reject')">Reject</button>
        <button type="button" class="btn btn-md btn-warning mb-1 mt-1"
            onclick="submitAttendanceApproval(this, 'hold')">Hold</button>
    </div>
    <table class="table table-striped table-bordered table-hover data-table">
        <thead class="thead-success">
            <tr>
                <th>SL#</th>
                <th class="text-left">Code</th>
                <th class="text-left">Employee Name</th>
                <th class="text-left">Department</th>
                <th class="text-left">unit</th>
                <th class="text-left">Designation</th>
                <th class="text-left">Att. Date</th>
                <th class="text-left">In Time</th>
                <th class="text-left">Out Time</th>
                <th class="text-left">Reason</th>
                <th class="text-left">Approval Detail</th>
                <th class="text-left" style="618px !important">Action</th>
                <th class="text-center" style="width:3%"><input type="checkbox" id="PathselectAll" /></th>
            </tr>
        </thead>
        <tbody id="">
            @if (!empty($pendingAttData))
                @foreach ($pendingAttData as $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $data->person_card_no }}</td>
                        <td class="text-left">{{ $data->full_name }}</td>
                        <td class="text-left">{{ $data->department }}</td>
                        <td class="text-left">{{ $data->unit }}</td>
                        <td class="text-left">{{ $data->designation_name }}</td>
                        <td class="text-left">
                            @if (!empty($data->attendance_date))
                                {{ date('d-m-Y', strtotime($data->attendance_date)) }}
                            @endif
                        </td>
                        <td class="text-left">
                            @if (!empty($data->in_time))
                            {{ date('h:i A', strtotime($data->in_time)) }}
                            @endif
                        </td>
                        <td class="text-left">
                            @if (!empty($data->out_time))
                            {{ date('h:i A', strtotime($data->out_time)) }}
                            @endif
                        </td>
                        <td class="text-left">{{ $data->remarks }}</td>
                        <td class="text-left">
                            @inject('attendance_approval_status', 'App\Http\Controllers\LeaveController')
                            @php
                                $approval_status = $attendance_approval_status->check_attendance_approval_status(
                                    $data->requsition_no_pk,
                                );
                            @endphp
                            <a style="cursor:pointer" class="open-modal btn btn-success btn-sm"
                                data-action="{{ route('v1.my.approval.level.detail.hr', $approval_status['apprprocess_no_pk']) }}"
                                data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm"
                                data-title="Approval Level Detail" title="Show">Show
                            </a>
                        </td>
                        <td class="text-left">
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
                                <input type="checkbox" class="attendance_pending" name="attendance_pending[]" value="{{ $approval_status['apprprocess_no_pk'] }},{{ $approval_status['approval_for_code'] }}">
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
            "columnDefs": [
                {
                    "width": "105px",
                    "targets": 6
                },
                {
                    "width": "90px",
                    "targets": 7
                },
                {
                    "width": "90px",
                    "targets": 8
                },
                {
                    "width": "280px",
                    "targets": 11
                },
                {
                    "orderable": false,
                    "targets": 12
                }
            ]
        });
    </script>
@endif
<script>
    function submitAttendanceApproval(element, status) {
        var formElement = document.getElementById('hr_attendance_approve');
        var formData = new FormData(formElement); 
        formData.append('status', status); 
        var url = $('#hr_attendance_approve').attr('action');
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
            $('.attendance_pending').prop('checked', true);
        } else {
            $('.attendance_pending').prop('checked', false);
        }
    });
</script>
