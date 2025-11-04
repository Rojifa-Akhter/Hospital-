<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .table thead th,
    .table thead td,
    .table tbody th,
    .table tbody td {
        vertical-align: middle;
    }
</style>

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center py-2 px-3">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">OT Requisition Status List</h5>
            <small>OT / OT Requisition Status List</small>
        </div>

        <div class="col-md-6">
            <form class="form-row align-items-end">
                <div class="form-group col-md-4 mb-1">
                    <label for="room_no" class="mb-1">OT Room No. <span class="text-danger">*</span></label>
                    <select class="select2 form-control form-control-sm font_size_12" id="room_no" name="room_no"
                        required>
                        <option value="">Select Room</option>
                        @foreach ($room_data as $data)
                            <option value="{{ $data->room_no_pk }}">{{ $data->room_name }} ({{ $data->room_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-5 mb-1">
                    <label for="from_date" class="mb-1">Schedule Date <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" id="from_date" name="from_date"
                            class="form-control form-control-sm date-picker" placeholder="From Date" autocomplete="off"
                            required>
                        <input type="text" id="to_date" name="to_date"
                            class="form-control form-control-sm date-picker ml-1" placeholder="To Date"
                            autocomplete="off" required>
                    </div>
                </div>

                <div class="form-group col-md-3 mb-1 text-right">
                    <button type="button" class="btn btn-md btn-primary w-100" id="load_schedule_btn">Show
                        Schedule</button>
                </div>
            </form>
        </div>
    </div>


    <div class="form-row">
        <div class="col-md-12 mt-2">

            <div class="tab-content p-0 bg-transparent" id="myTabContent">
                <div class="tab-pane fade active show" id="requisition-list" role="tabpanel"
                    aria-labelledby="requisition-list-tab">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('ot.search-requisition-print') }}" id="ot-requisition-search-status"
                                method="post" target="_blank">
                                @csrf
                                <div class="form-row justify-content-center border-bottom">
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm"
                                            for="prescription_uid">Prescription ID</label>
                                        <input type="text" class="form-control form-control-sm m-0"
                                            id="prescription_id" name="prescription_uid" value=""
                                            placeholder="Prescription ID">
                                        <input type="hidden" id="hdn_presc_id" name="hdn_presc_id">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="admission_id">Admission
                                            ID</label>
                                        <input type="text" class="form-control form-control-sm m-0" id="admission_id"
                                            name="prescription_id" value="" placeholder="Admission ID">
                                        <input type="hidden" id="hdn_admission_id" name="hdn_admission_id">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="admission_id">UHID</label>
                                        <input type="text" class="form-control form-control-sm m-0" name="patient_id"
                                            id="patient_id" autocomplete="off" placeholder="Patient ID" />
                                        <input type="hidden" class="form-control" id="hdn_patient_id"
                                            name="hdn_patient_id" />
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="col-form-label col-form-label-sm" for="admission_date_from">OT
                                            Requisition Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">From</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date-picker"
                                                id="ot_req_date_from" name="ot_req_date_from"
                                                value="{{ date('d-m-Y') }}" placeholder="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">To</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date-picker"
                                                id="ot_req_date_to" name="ot_req_date_to" value="{{ date('d-m-Y') }}"
                                                placeholder="dd-mm-yyyy">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label class="col-form-label col-form-label-sm" for="ot_status">OT
                                            Status</label>
                                        <select name="ot_status" id="ot_status"
                                            class="form-control form-control-sm m-0">
                                            <option value="">All</option>
                                            <option value="PENDING">Pending</option>
                                            <option value="CONFIRM">Confirm</option>
                                            <option value="REJECTED">Rejected</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="btn-group btn-block" role="group">
                                            <button type="button"
                                                onclick="generateSearch( this, 'ot-requisition-search-status', '{{ route('ot.ot-requisition-status-search') }}', 'requisition-list-search' )"
                                                class="btn btn-success btn-block btn-md mt-4"><i
                                                    class="fa fa-search"></i> Search</button>
                                            <button type="reset" class="btn btn-info btn-block btn-md mt-4"><i
                                                    class="fa fa-redo"></i>Reset</button>
                                            <button type="submit"
                                                class="btn btn-md btn-primary btn-block mt-4 print">
                                                Export
                                                PDF</button>

                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="form-row">
                                <div class="col-12 mt-2 table-responsive" id="requisition-list-search">
                                    <table class="table data-table table-striped table-bordered table-hover mb-0">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th class="text-center">SL</th>
                                                <th class="text-center">Patient Name</th>
                                                <th class="text-center">Req. ID</th>
                                                <th class="text-center">Prescription ID</th>
                                                <th class="text-center">Admission ID</th>
                                                <th class="text-center">UHID</th>
                                                <th class="text-center">Dept. Name</th>
                                                <th class="text-center">Ward/Cabin Name</th>
                                                <th class="text-center">Age</th>
                                                <th class="text-center">Sex</th>
                                                <th class="text-center">Requisition Date</th>
                                                <th class="text-center">Proposed operation</th>
                                                <th class="text-center">OT Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @dd($ot_requisition_wl); --}}
                                            @if ($ot_requisition_wl)
                                                @foreach ($ot_requisition_wl as $ot_req)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ $ot_req->patient_name ?? '' }}</td>
                                                        <td>{{ $ot_req->ot_req_no_pk ?? '' }}</td>
                                                        <td>{{ $ot_req->prescription_no_fk ?? '' }}</td>
                                                        <td>{{ $ot_req->admission_uid ?? '' }}</td>
                                                        <td>{{ $ot_req->patient_code ?? '' }}</td>
                                                        {{-- নতুন UHID ফিল্ড --}}
                                                        <td>{{ $ot_req->new_serivce_unit_name ?? '' }}</td>
                                                        <td>{{ $ot_req->ward_name ?? '' }}</td>
                                                        <td>{{ $ot_req->age ?? '' }}</td>
                                                        <td>{{ $ot_req->gender_txt ?? '' }}</td>
                                                        <td>{{ !empty($ot_req->ot_req_date) ? date('d/m/Y H:i A', strtotime($ot_req->ot_req_date)) : '' }}
                                                        </td>
                                                        <td>{{ $ot_req->item_name ?? '' }}</td>
                                                        <td class="text-center">
                                                            @php
                                                                $status = 'Pending';
                                                                if ($ot_req->ot_comfirmation_ind == 1) {
                                                                    $status = 'Confirm';
                                                                } elseif ($ot_req->reject_ind == 1) {
                                                                    $status = 'Reject';
                                                                }

                                                                $isConfirmed = $ot_req->ot_comfirmation_ind == 1;
                                                                $isRejected = $ot_req->reject_ind == 1;
                                                                $adm_id = $ot_req->admission_uid;
                                                                if ($ot_req->admission_uid == null) {
                                                                    $adm_id = 0;
                                                                }
                                                            @endphp

                                                            @if ($status == 'Pending')
                                                                <button type="button"
                                                                    class="btn btn-success btn-sm open-modal"
                                                                    data-modal="common-modal-sm"
                                                                    data-title="OT Confirmation"
                                                                    data-action="{{ route('ot-confirmation-popUp', [$ot_req->ot_req_no_pk, $adm_id]) }}"
                                                                    title="OT Confirmation">
                                                                    Confirm
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm open-modal"
                                                                    data-modal="common-modal-sm"
                                                                    data-title="OT Rejection"
                                                                    data-action="{{ route('ot.ot-rejection-popUp', $ot_req->ot_req_no_pk) }}">
                                                                    Reject
                                                                </button>
                                                            @elseif($status == 'Confirm')
                                                                <span class="badge bg-success">Confirmed</span>
                                                            @else
                                                                <span class="badge bg-danger">Rejected</span>
                                                            @endif

                                                            <div class="mt-1 small text-muted">
                                                                @if ($isConfirmed)
                                                                    Confirmed by
                                                                    <strong>{{ $ot_req->ot_comfirmation_doc_name ?? '—' }}</strong>
                                                                    on
                                                                    {{ $ot_req->ot_comfirmation_time ? date('d/m/Y H:i A', strtotime($ot_req->ot_comfirmation_time)) : '—' }}
                                                                @elseif ($isRejected)
                                                                    Rejected by
                                                                    <strong>{{ $ot_req->ot_reject_by_name ?? '—' }}</strong>
                                                                    on
                                                                    {{ $ot_req->reject_time ? date('d/m/Y H:i A', strtotime($ot_req->reject_time)) : '—' }}
                                                                    <br>
                                                                    <em>Reason:</em>
                                                                    {{ $ot_req->reject_note ?? '—' }}
                                                                @endif
                                                            </div>

                                                            <div>
                                                                @if($ot_req->admission_no_fk !='')
															<a href="{{ route('billing.pharmacy-bill-generate', [$ot_req->admission_no_fk,7]) }}" class="open-modal btn btn-sm btn-primary text-white" target="_blank" rel="noopener noreferrer"> Med Bill </a>
															<a href="{{ route('uhl.billing-invoice-form', $ot_req->patient_no_fk.'-'.$ot_req->admission_no_fk.'-OT') }}" class="open-modal btn btn-sm btn-primary text-white" target="_blank" rel="noopener noreferrer">  Bill </a>
														
														@endif
                                                            </div>
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

<!-- Modal -->
<div class="modal fade" id="scheduleListModal" tabindex="-1" role="dialog"
    aria-labelledby="scheduleListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document"> <!-- modal-xl for wider view -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleListModalLabel">OT Schedule List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_schedule_content">
                <!-- Schedule content will be injected here via AJAX -->
                <div class="text-center text-muted">Loading...</div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // SideBar Collapse
        $("body").addClass("sidebar-collapse");

        var table = $('.data-table').DataTable({
            "lengthMenu": [
                [10],
                [10]
            ],
            "ordering": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bAutoWidth": false
        });

        $('.date-picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });

        function selectedPatient(item, obj) {
            $("#patient_id").val(" ");
            var phone_no = item.doctphone_mobileor_mobile ? " , <strong>Phone : </strong>" + item
                .doctphone_mobileor_mobile : "";
            var name = item.patient_name ? " , <strong>Name : </strong>" + item.patient_name : "";
            var PID = item.patient_code ? "<strong>PID : </strong>" + item.patient_code : "";
            var patient_information = PID + name + phone_no;
            $("#patient_info").html(patient_information);

        }

        $(document).ready(function() {
            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#printOtRequisition").on('click', function() {
                var formID = $("#ot-requisition-search-status").attr("id");

                $.ajax({
                    data: $("#" + formID).serialize(),
                    url: '{{ route('ot.search-requisition-print') }}',
                    type: "post",

                    success: function(data) {

                    },
                    error: function(xhr, status, error) {

                        unblockUI(); // Ensure loading indicator is hidden
                    }
                });
            });
        });

        function changeStatus(ot_req_id, status) {
            if (!confirm('Are you sure to change status to ' + status + '?')) return;

            $.ajax({
                url: '/ot/update-status',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ot_req_id: ot_req_id,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        alert('Status updated successfully');
                        location.reload();
                    } else {
                        alert('Failed to update status');
                    }
                },
                error: function() {
                    alert('Something went wrong');
                }
            });
        }


        $('#load_schedule_btn').on('click', function() {
            let room_id = $('#room_no').val();
            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();

            if (!room_id || !from_date || !to_date) {
                alert("Please select room and date range properly.");
                return;
            }

            // Open Modal
            $('#scheduleListModal').modal('show');

            // Optional loading indicator
            $('#modal_schedule_content').html('<div class="text-center text-muted">Loading...</div>');

            // Call AJAX to get schedule
            $.ajax({
                type: "POST",
                url: "{{ route('get-ot-schedule-for-status') }}",
                data: {
                    room_id: room_id,
                    from_date: from_date,
                    to_date: to_date
                },
                success: function(data) {
                    $('#modal_schedule_content').html(data
                        .html); // this 'html' must be returned from controller
                },
                error: function() {
                    $('#modal_schedule_content').html(
                        '<div class="text-danger">Something went wrong!</div>');
                }
            });
        });



        openAdmissionAutocomplete('#admission_id');
        openPrescriptionAutocomplete(
            '#prescription_id');
        openPatientAutocomplete('#patient_id');


    })
</script>
