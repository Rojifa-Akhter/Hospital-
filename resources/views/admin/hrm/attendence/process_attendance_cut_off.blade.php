<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_appointment">
    <div class="container-fluid">
        <div
            class="row bg-white justify-content-between align-items-center border-bottom sticky-top-breadcrumb shadow-sm align-items-center py-2">
            <div class="col-md-4">
                <h5 class="mt-2 mb-0">Process Attendance Cut Off</h5>
                <small>Payroll/Salary Process/Process Attendance Cut Off</small>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <form action="{{ route('hrm.process_attendance_cut_off_store') }}" method="post"
                        id="leave-setup-create">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <div class="form-group form-row ml-2 form-row">
                            <div class="col-md-5">
                                <label for="year" class=" col-form-label col-form-label-sm">Year<span
                                        style="color:red">*</span></label>
                                <select class="form-control font_size_12 m-auto" id="year" name="year" required>
                                    <option value="0">Select Year</option>
                                    @php
                                        $date = date('Y');
                                    @endphp
                                    @for ($i = $date - 2; $i < $date + 3; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="year" class="col-form-label col-form-label-sm">Month<span
                                        style="color:red">*</span></label>
                                <select class="form-control font_size_12 m-auto" id="month" name="month"
                                    width="200px" required>
                                    <option value="0">Select Month</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>

                            @php
                                $response_action = route('hrm.process_attendance_cut_off');
                            @endphp
                            <div class="col-md-2 mt-4">
                                <button type="submit" class="btn btn-success btn-md btn-md-global uhl_common_btn"
                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Process</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5> Search</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row justify-content-center border-bottom">
                            <div class="col-md-12">
                                <form method="post" target="_blank" id='searchForm'
                                    action="{{ route('hrm.attendence-monthly-pdf') }}" data-response-action="">
                                    @csrf
                                    <input type="hidden" name="id" value="">
                                    <div class="form-group  form-row">
                                        <label for="year" class=" col-form-label col-form-label-sm">Year</label>
                                        <div class="col-md-1">
                                            <select class="form-control font_size_12 " id="year" name="year"
                                                required>
                                                <option value="">Select</option>
                                                @php
                                                    $date = date('Y');
                                                @endphp
                                                @for ($i = $date - 2; $i < $date + 3; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <label for="year" class="col-form-label col-form-label-sm">Month</label>
                                        <div class="col-md-2  ">
                                            <select class="form-control font_size_12  " id="month" name="month"
                                                width="200px" required>
                                                <option value="">Select</option>
                                                <option value="01">January</option>
                                                <option value="02">February</option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>

                                            </select>
                                        </div>
                                        <label for="status"
                                            class="col-form-label col-form-label-sm">Department</label>
                                        <div class="col-md-2">
                                            <select class="form-control font_size_12  select2" id="department"
                                                name="department">
                                                <option value="">Select Department</option>
                                                @if (!empty($service_unit))
                                                    @foreach ($service_unit as $value)
                                                        <option value="{{ $value->serviceunit_no_pk }}">
                                                            {{ $value->serviceunit_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <label for="card_no"
                                            class=" col-form-label col-form-label-sm ">Employee</label>
                                        <div class=" col-md-2">
                                            <input type="text" class="form-control form-control-sm m-0 keep_me"
                                                id="employee_code" name="employee_code" value=""
                                                placeholder="Code/Name/Phone Number" />
                                            <input type="hidden" class="keep_me" id="hdn_item_item_id_0"
                                                name="card_num" value="">
                                            @error('employee_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>

                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-md btn-md-global btn-success"
                                                id="btnSearchReport">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="col-md-12 table-responsive" id="attendance_cut_off_container">
                                @include('admin.hrm.attendence.process_attendance_cut_off_list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>

<script type="text/javascript">
    openDoctorAutocomplete("#employee_code", 'hdn_item_item_id_0');

    $('.select2').select2({});

    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'yyyy-mm-dd',
    });
    $('.date-picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy',
    });

    $(document).on("click", "#btnSearchReport", function(e) {
        var formID = $("#searchForm").attr("id");
        // var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#searchForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('hrm/attendence-cut-off-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#attendance_cut_off_container").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $("#daily_date").change(function() {
        if ($(this).is(':checked')) {
            $('#date_only').addClass('d-none');
        } else {
            $('#date_only').removeClass('d-none');

        }
    });
</script>
