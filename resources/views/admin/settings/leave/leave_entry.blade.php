<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<style>
    .dataTables_wrapper .dataTables_filter input {
        width: 190px;
        margin-top: 10px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Leave Entry</h5>
            <small>Settings / Leave Entry / Leave Entry</small>
        </div>
    </div>
    <form action="{{ route('leave.store') }}" method="post" id="search-employee"> @csrf
        <div class="form-row">

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Search Employee <span class="text-danger">*</span></h5>
                    </div>

                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-12 mt-1">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm m-0 keep_me"
                                        id="employee_code" name="employee_code" value="{{ $user_info->user_fullname }}"
                                        placeholder="Employee Code/Name/Phone Number" />
                                    <input type="hidden" class="keep_me" id="hdn_item_item_id_0"
                                        name="hdn_item_item_id_0" value="{{ $user_info->person_no_fk }}">
                                    @error('employee_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <div class="">
                                    <button type="button" class="btn btn-md btn-success" id="btnSearch"
                                        data-action="{{ route('leave.search-employee-leave-status') }}"><i
                                            class="fa fa-search"></i>Search</button>
                                    <button type="reset" class="btn btn-md btn-info"> Clear </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="form-row ">
                            <div id="search-result" class="col-12 table-responsive">
                                <table id=""
                                    class="data-table table-bordered table-hover table-striped mt-2 border mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th colspan="2"
                                                style="background-color: rgba(0, 0, 0, 0.03);border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                                                <span>Allocated Leave</span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Leave Name</th>
                                            <th class="text-left">Total Days</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($leave_info))
                                            @foreach ($leave_info as $leave_data)
                                                <tr>
                                                    <td class="text-left">
                                                        {{ $leave_data->leave_type_lkp_name }} </td>
                                                    <td class="text-left"> {{ $leave_data->no_of_days }} </td>
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
            <div class="col-md-9" id="result-data">

                <div class="card">
                    <div class="card-header">
                        <h5>Leave Entry</h5>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="id" value="">
                        <div class="form-row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="leave_name" class="col-form-label col-form-label-sm">Leave Name <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2 keep_me" id="leave_name" name="leave_name">
                                        <option value="">Select Leave Name</option>
                                        @if (!empty($leave_info))
                                            @foreach ($leave_info as $leave_data)
                                                <option value="{{ $leave_data->leave_type_lkp_no_fk }}">
                                                    {{ $leave_data->leave_type_lkp_name }}({{ $leave_data->leave_code }})-{{ $leave_data->no_of_days }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="from_date">Day
                                        From <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="from_date" name="from_date" value="{{ date('d-m-Y') }}"
                                        placeholder="{{ date('d-m-Y') }}" required />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="to_dates">Day To
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="to_dates" name="to_dates" value="{{ date('d-m-Y') }}" required
                                        placeholder="{{ date('d-m-Y') }}" required />
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top: 26px !important;">
                                <div class="form-group">
                                    <span class="bg-secondary p-1 rounded text-light">Requested Leave
                                        &nbsp;&nbsp;
                                        <span class="text-light bg-danger rounded px-1" id="req_leave"> </span>&nbsp;
                                        days
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="leave_reason">Reason <span
                                            class="text-danger">*</span> </label>
                                    <input class="form-control form-control-sm m-0 " id="leave_reason"
                                        name="leave_reason" value="" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="">Assign To</label>
                                    <input type="text" class="form-control form-control-sm m-0 keep_me"
                                        id="search_employee_code" name="search_employee_code"
                                        placeholder="Search Employee" />
                                    <input type="hidden" class="keep_me" id="hdn_item_item_id_0_search"
                                        name="hdn_item_item_id_0_search" value="">
                                    @error('employee_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="">Extra Duty
                                        On</label>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="extra_duty_on" name="extra_duty_on" placeholder="Extra Duty Date" />
                                </div>
                            </div>

                            <div class="col-md-3 ">
                                <button class="btn btn-success btn-md uhl_save_btn" type="button"
                                    onclick="leaveSaveData(this)">
                                    Save
                                </button>
                                <button type="reset" class="btn btn-md btn-info"> Clear </button>
                                <a class="btn btn-md btn-danger" href="{{ route('admin-dashboard') }}"> Exit </a>

                            </div>
                        </div>

                    </div>
                </div>

                <div id="search-container">
                    @include('admin.settings.leave.leave_list')
                </div>
            </div>
        </div>
    </form>

</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var start = $("#from_date").datepicker("getDate");
        var end = $("#to_dates").datepicker("getDate");
        var days = (end - start) / (1000 * 60 * 60 * 24);
        var actualDay = Math.round(days) + 1;
        $("#req_leave").text(actualDay);
        $("#days_show").val(actualDay);

        $('#from_date,#to_dates').change(function(e) {
            var start = $("#from_date").datepicker("getDate");
            var end = $("#to_dates").datepicker("getDate");
            var days = (end - start) / (1000 * 60 * 60 * 24);
            var actualDay = Math.round(days) + 1;
            $("#req_leave").text(actualDay);
            $("#days_show").val(actualDay);
        });
    });

    function leaveSaveData(thisElement) {
        if ($("#hdn_item_item_id_0").val() != "") {
            let response_url = '{{ route('leave.index') }}'
            btnSaveUpdate(thisElement, '', '', '', '', dynamicFunc.afterSaveLoadPage, response_url);
        } else {
            alert("Enter Employee Name")
            return;
        }

    }


    function searchEmployee() {

        var employee_id = $("#hdn_item_item_id_0").val();
        var btnAction = $("#btnSearch").attr("data-action");
        $.ajax({
            data: {
                employee_id: employee_id
            },
            url: btnAction,
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#search-container").html(data);
            },
            error: function(data) {
                var errors = jQuery.parseJSON(data.responseText).errors;
                error_messages = "";
                for (messages in errors) {
                    var field_name = $("#" + messages).siblings("label").html();
                    error_messages += "<div class='alert alert-danger' role='alert'>" + errors[messages] +
                        "</div>";
                }

                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html(error_messages);

                $.unblockUI();
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    $(document).on("click", "#btnSearch", function(e) {
        searchEmployee();
    });



    openDoctorAutocomplete("#employee_code", 'hdn_item_item_id_0');
    openDoctorAutocomplete("#search_employee_code", 'hdn_item_item_id_0_search');

    $('.select2').select2({});


    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
</script>
