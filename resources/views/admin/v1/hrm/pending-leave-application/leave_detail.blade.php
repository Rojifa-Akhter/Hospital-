<style>
    .upload_label {
        position: absolute;
        left: 50%;
        top: 100%;
        transform: translate(-50%, 0%);
    }

    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }

    table td,
    th {
        font-size: 14px
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm pb-3">
                        <div class="col-md-3">
                            <h5 class="mt-2 mb-0">Approval Pending Leave</h5>
                            <small>HRM / Approval Pending Leave</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="text-align:center;" class="mb-2">
                                        <p><strong style="border-bottom: 1px solid">Employee Information</strong></p>
                                    </div>
                                    <table style="width: 100%;border-collapse:collapse; margin-bottom: 20px; border:0;"
                                        cellpadding="1" cellspacing="0" border="1">
                                        <thead>
                                            <tr class="table-tr">
                                                <td style="text-align: center; font-size:14px" scope="col">
                                                    Name: <strong>{{ $personDetails->full_name }} </strong>
                                                </td>
                                                <td style="text-align: center" scope="col">
                                                    Employee Id: <strong>{{ $personDetails->person_code }} </strong>
                                                </td>
                                                <td style="text-align: center" scope="col">
                                                    Department: <strong>{{ $personDetails->su_name }}</strong>
                                                </td>
                                                <td class="text-center" scope="col">
                                                    Designation: <strong> {{ $personDetails->designation }}</strong>
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="text-align:center;" class="mb-2">
                                        <p><strong style="border-bottom: 1px solid">Approval Pending Leave</strong></p>
                                    </div>
                                    <div class="">
                                        <table class="table table-striped table-bordered table-hover data-table" style="margin-bottom: 20px;">
                                            <thead class="thead-success">
                                                <tr>
                                                    <th>SL#</th>
                                                    <th class="text-left">Leave Type</th>
                                                    <th class="text-left">From Date</th>
                                                    <th class="text-left">To Date</th>
                                                    <th class="text-center">Total Days</th>
                                                    <th class="text-left">Reason</th>
                                                    <th class="text-left">Approval Detail</th>
                                                    <th class="text-left">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="">
                                                @if (count($appliedLeave) > 0)
                                                    @foreach ($appliedLeave as $data)
                                                        @inject('leave_approval_status','App\Http\Controllers\LeaveController')
                                                        @php
                                                        $approval_status = $leave_approval_status->check_leave_approval_status($data->leave_no_pk);
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td class="text-left">{{ $data->leave_type_name }}
                                                            </td>
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
                                                            <td class="text-left">
                                                                {{ $data->leave_reason }}
                                                                {{ isset($data->al_dayoff_date) ? '(HD: ' . date('d-m-Y', strtotime($data->al_dayoff_date)) . ')' : '' }}
                                                            </td>
                                                            <td class="text-left">
                                                                <a style="cursor:pointer" class="open-modal btn btn-success btn-sm" data-action="{{ route('v1.my.approval.level.detail.hr', $approval_status['apprprocess_no_pk']) }}" data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm" data-title="Approval Level Detail"  title="Show">Show
                                                                </a>
                                                            </td>
                                                            <td class="text-left">  
                                                                @if($approval_status['approval_status'] == 1 && $approval_status['hold_status'] == 0 ) 
                                                                    <button  type="button" class="btn btn-md btn-outline-success mb-1 mt-1 open-modal" data-action="{{ route('v1.edit.my.approval.status', [$approval_status['apprprocess_no_pk'] . '*' . $approval_status['approval_for_code'],
                                                                       'hr_status']) }}" data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm" data-title="Approve"  title="Approve">Approve</button>

                                                                    <button type="button" class="btn btn-md btn-danger mb-1 mt-1 open-modal" data-action="{{ route('v1.reject.my.approval.status',[ $approval_status['apprprocess_no_pk'], $approval_status['approval_for_code'], 'hr_status']) }}" data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm" data-title="Reject"  title="Reject">Reject</button>
                                                                    
                                                                    <button 
                                                                    type="button" class="btn btn-md btn-warning mb-1 mt-1 open-modal" data-action="{{ route('v1.hold.my.approval.status',$approval_status['apprprocess_no_pk']) }}" data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm" data-title="Hold"  title="Hold">Hold</button>
                                                                @elseif($approval_status['approval_status'] == 1 && $approval_status['hold_status'] == 1)
                                                                    <button type="button" class="btn btn-md btn-warning mb-1 mt-1 open-modal" data-action="{{ route('v1.unHold.my.approval.status',$approval_status['apprprocess_no_pk']) }}" data-id="{{ $approval_status['apprprocess_no_pk'] }}" data-modal="common-modal-sm" data-title="Unhold" title="Unhold">Unhold</button>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div style="text-align:center;" class="mb-2">
                                        <p><strong style="border-bottom: 1px solid">Leave Information</strong></p>
                                    </div>
                                    <div class="">
                                        <table class="table table-striped table-bordered table-hover data-table" style="margin-bottom: 20px;">
                                            <thead class="thead-success">
                                                <tr>
                                                    <th>SL#</th>
                                                    <th class="text-left">Leave Type</th>
                                                    <th class="text-center">Entitled</th>
                                                    <th class="text-center">Availed</th>
                                                    <th class="text-center">Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody id="">
                                                @if (!empty($info))
                                                    @foreach ($info as $leave_data)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td class="text-left">{{  $leave_data->leave_type_lkp_name  }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{{ $leave_data->no_of_days }}}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $leave_data->leave }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $leave_data->no_of_days - $leave_data->leave }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div style="text-align:center;" class="mb-2">
                                        <p><strong style="border-bottom: 1px solid">Availed Leave Detail</strong></p>
                                    </div>
                                    <div class="">
                                        <table class="table table-striped table-bordered table-hover data-table2" style="margin-bottom: 20px;">
                                            <thead class="thead-success">
                                                <tr>
                                                    <th>SL#</th>
                                                    <th class="text-left">Leave Type</th>
                                                    <th class="text-left">From Date</th>
                                                    <th class="text-left">To Date</th>
                                                    <th class="text-center">Total Days</th>
                                                    <th class="text-left">Reason</th>
                                                </tr>
                                            </thead>
                                            <tbody id="">
                                                @if (!empty($availedInfo))
                                                    @foreach ($availedInfo as $availed_data)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td class="text-left">{{ $availed_data->leave_type_name  }}
                                                            </td>
                                                            <td class="text-left">
                                                                @if (!empty($availed_data->from_date))    
                                                                {{ date('d/m/Y', strtotime($availed_data->from_date)) }}
                                                                @endif
                                                            </td>
                                                            <td class="text-left">
                                                                @if (!empty($availed_data->to_dates))
                                                                {{ date('d/m/Y', strtotime($availed_data->to_dates)) }}
                                                            @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if (!empty($availed_data->from_date) && !empty($availed_data->to_dates))
                                                                <?php
                                                                    $date1 = new DateTime($availed_data->from_date);
                                                                    $date2 = new DateTime($availed_data->to_dates);
                                                                    $interval = $date1->diff($date2);
                                                                    echo $interval->days + 1;
                                                                ?>
                                                                @endif
                                                            </td>
                                                            <td class="text-left">
                                                                {{ $availed_data->leave_reason }} 
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
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $(document).ready(function() {
        $('.select2').select2();
    });
    $('.data-table').DataTable({
        "ordering": false,
        "searching": false,
        // "lengthMenu": [15, 30, 50, 70, 100],
        "dom": 'rtip',
        "paging": false,
        "pageLength": 15,
        "info": false
    });
    $('.data-table2').DataTable({
        "ordering": true,
        "searching": true,
        "lengthMenu": [6, 10, 50, 70, 100],
        "pageLength": 6,
    });

    // $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
</script>
