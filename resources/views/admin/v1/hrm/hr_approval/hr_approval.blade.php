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
                    <div class="row bg-white border-bottom sticky-top shadow-sm pb-1">
                        <div class="col-md-3">
                            <h5 class="mt-2 mb-0">HR Approval</h5>
                            <small>HRM / HR Approval</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-2">
                            <div>
                                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="leave-pending" 
                                        href="{{ route('hrm.hr-approval') }}" role="tab" 
                                            href="route('hrm.hr-approval')">Leave Pending<span
                                                class="badge badge-secondary"></span></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="attendance-pending" 
                                        href="{{ route('hrm.hr-attendance-approval')}}" role="tab">Attendance Pending<span class="badge badge-secondary"></span></a>
                                    </li>

                                </ul>
                                <div class="tab-content p-0" id="myTabContent">
                                    <div class="tab-pane fade show active ppp" id="leave_pending" role="tabpanel" aria-labelledby="leave-pending">
                                        <form method="post" id="frmSearch" data-response-action="" action=""
                                            target="_blank">
                                            @csrf
                                            <div class="row">
                                                {{-- <div class="col-md-2"></div> --}}
                                                <div class="col-md-2">
                                                    <label for="card_no"
                                                        class=" col-form-label col-form-label-sm ">Card No</label>
                                                    <input type="text" class="form-control form-control-sm "
                                                        id="card_no" name="card_no" value=""
                                                        placeholder="Card no">
                                                    <input type="hidden" name="card_hidn" id="card_hidn">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="department"
                                                        class=" col-form-label col-form-label-sm ">Department</label>
                                                    <select class="form-control select2" id="department"
                                                        name="department" style="margin:0px!important;">
                                                        <option value="">Select Department</option>
                                                        @if (isset($departments))
                                                            @foreach ($departments as $value)
                                                                <option value="{{ $value->serviceunit_no_fk_dept }}">
                                                                    {{ $value->serviceunit_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="unit"
                                                        class=" col-form-label col-form-label-sm ">Unit</label>
                                                    <select class="form-control select2" id="unit"
                                                        name="unit" style="margin:0px!important;">
                                                        <option value="">Select Unit</option>
                                                        @if (isset($units))
                                                            @foreach ($units as $value)
                                                                <option value="{{ $value->serviceunit_no_fk }}">
                                                                    {{ $value->serviceunit_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="leave_type"
                                                        class="col-form-label col-form-label-sm ">Leave Type</label>
                                                        <select class="form-control select2" id="leave_type" name="leave_type">
                                                            <option value="">Select Leave Type</option>
                                                            @if (!empty($leaveType))
                                                                @foreach ($leaveType as $data)
                                                                    <option value="{{$data->leave_type_lkp_no_fk}}">
                                                                        {{ $data->leave_type_lkp_name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="day_no"
                                                        class=" col-form-label col-form-label-sm ">No. of Days</label>
                                                    <input type="text" class="form-control form-control-sm "
                                                        id="day_no" name="day_no" value="" autocomplete="off">
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="from_date"
                                                        class=" col-form-label col-form-label-sm ">From
                                                        Date</label>
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker" id="from_date"
                                                        name="from_date" placeholder="DD-MM-YYYY" required
                                                        autocomplete="off"
                                                        value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}">
                                                    <span class="focus_input"></span>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="user_expire_date"
                                                        class=" col-form-label col-form-label-sm ">To
                                                        Date</label>
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker" id="to_date"
                                                        name="to_date" placeholder="DD-MM-YYYY" required
                                                        autocomplete="off" value="{{ date('d-m-Y') }}">
                                                    <span class="focus_input"></span>
                                                </div>
                                                <div class="col-md-1 text-center mt-4">
                                                    <div class="btn-group btn-block" role="group">
                                                        <button type="button"
                                                            class="btn btn-md btn-outline-success btn-md-global mt-0"
                                                            id="searchHrApproval" onclick="">
                                                            Search</button>
                                                    </div>
                                                </div>
                                            </div>    
                                        </form>
                                        <div class="table-responsive" id="hr_approval_list_id">
                                            @include('admin.v1.hrm.hr_approval.hr_approval_list')
                                        </div>
                                    </div>
                                    <div class="tab-pane fade lll" id="attendance_pending" role="tabpanel" aria-labelledby="attendance-pending">
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
      $(document).ready(function() {
        $('.select2').select2();
    });
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
    $('.data-table').DataTable({
        "ordering": true,
        "searching": true,
        // "lengthMenu": [15, 30, 50, 70, 100],
        // "pageLength": 15
        "paging": false,
        "columnDefs": [{
                "width": "280px",
                "targets": 11
            },
            {
                "orderable": false,
                "targets": 12
            }
        ]
    });

    $(document).on("click", "#searchHrApproval", function(e) {
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('hrm/search-hr-approval-list') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#hr_approval_list_id").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
        e.stopImmediatePropagation();
    });
    
</script>
