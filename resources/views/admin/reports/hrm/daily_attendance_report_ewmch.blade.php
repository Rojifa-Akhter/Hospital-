<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Daily Attendance Report</h5>
                <small>Report / HRM / Daily Attendance Report</small>
            </div>
        </div>
        <div class="card mt-2" style="width: 100%; margin: auto">
            <div class="card-header ">
                <h5>Search</h5>
            </div>
            <div class="card-body ">
                <div class="form-row mt-2">
                    <div class="col-md-12 ">
                        {{-- @if (Session::get('user.ses_hospital_code') != 'UNICO')
                        @php
                            $action = 'hrm.daily_attendance_report_print';
                        @endphp
                        @else
                        @php
                            $action = 'hrm.daily_attendance_report_printv1';
                        @endphp
                        @endif --}}
                        <form method="post" id="frmSearch" data-response-action=""
                            action="{{ route('hrm.daily_attendance_report_print') }}" target="_blank">
                            @csrf
                            <div class=" justify-content-center  form-row">
                                <input type="hidden" name="id" value="">

                                <div class="col-md-2 ">
                                    <label for="card_no" class="col-form-label col-form-label-sm ">Card No</label>
                                    <input type="text" class="form-control form-control-sm " id="card_no"
                                        name="card_no" value="" placeholder="Card no">
                                    <input type="hidden" name="card_hidn" id="card_hidn">

                                </div>


                                <div class="col-md-2">
                                    <label for="user_expire_date" class="col-form-label col-form-label-sm ">
                                        Date</label>
                                    <input type="text" class="form-control form-control-sm date_picker"
                                        id="date_pic" name="date_pic" value="{{ date('d-m-Y') }}"
                                        placeholder="YYYY/DD/MM">
                                    <span class="focus_input"></span>
                                </div>

                                <div class="col-md-2">
                                    <label for="user_expire_date" class="col-form-label col-form-label-sm">To
                                        Date</label>
                                    <input type="text" class="form-control form-control-sm date_picker"
                                        id="date_pic2" name="date_pic2" value="{{ date('d-m-Y') }}"
                                        placeholder="YYYY/DD/MM">
                                    <span class="focus_input"></span>
                                </div>


                                <div class=" col-md-2 ">
                                    <label for="department_name"
                                        class=" col-form-label col-form-label-sm ">Department</label>
                                    <select class="form-control select2" id="department_name" name="department_name"
                                        style="margin:0px!important;">
                                        <option value="">Select Department</option>
                                        @if (isset($dept))
                                            @foreach ($dept as $value)
                                                <option value="{{ $value->serviceunit_no_pk }}">
                                                    {{ $value->serviceunit_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>

                                <div class=" col-md-2 ">
                                    <label for="designation_name"
                                        class=" col-form-label col-form-label-sm ">Designation</label>
                                    <select class="form-control select2" id="designation_name" name="designation_name"
                                        style="margin:0px!important;">
                                        <option value="">Select Designation</option>
                                        @if (isset($desig))
                                            @foreach ($desig as $value)
                                                <option value="{{ $value->designation_no_pk }}">
                                                    {{ $value->designation_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                                <div class=" col-md-2 ">
                                    <label for="att_status" class=" col-form-label col-form-label-sm ">Attendance
                                        Status</label>
                                    <select class="form-control " id="att_status" name="att_status"
                                        style="margin:0px!important;">
                                        <option value="">Select Status</option>

                                        {{-- <option value="0">Abnormal/Single</option> --}}
                                        <option value="1">Present</option>
                                        <option value="5">Absent</option>
                                        {{-- <option value="2">Late</option> --}}
                                        <option value="3">Leave</option>
                                        {{-- <option value="4">Leave without pay</option> --}}
                                        {{-- <option value="6">day off</option> --}}
                                        {{-- <option value="7">Natinal Holiday</option> --}}
                                        <option value="88">In Less</option>
                                        <option value="99">Out Less</option>

                                    </select>

                                </div>
                                <input type="hidden" value="EXCEL" name="hdn_report_type" id="hdn_report_type">
                                <input type="hidden" class="form-control form-control-sm m-0 " id="daily_date" name="daily_date" value="0">
                                <div class="col-lg-7 col-md-6 text-center mt-2">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button"
                                            class="btn btn-md btn-success btn-md-global btn-block mt-0"
                                            id="dailyAttSearchReport" onclick=""> <i class="fas fa-search"></i>
                                            Search</button>

                                        {{-- @if (Session::get('user.ses_hospital_code') != 'UNICO') --}}
                                            <button type='submit'
                                            class="btn btn-info btn-block btn-md btn-md-global mt-0 print"
                                            value="1" onclick="exportPDFIPD()"><i class="fa fa-file-pdf"></i>
                                            Export PDF</button>
                                            <button type='button' class="btn btn-primary btn-block btn-md btn-md-global mt-0 print"
                                            value="1" onclick="exportPDF('PDF', '{{ route('hrm.daily_attendance_report_printv1') }}')">
                                            <i class="fa fa-file-pdf"></i> Export PDF V1
                                            </button>

                                            <button type='button' class="btn btn-success btn-block btn-md btn-md-global mt-0 print"
                                            value="1" onclick="exportPDF('EXCEL', '{{ route('hrm.daily_attendance_report_printv1') }}')">
                                            <i class="fa fa-file-pdf"></i>Export In Excel V1
                                            </button>

                                        <button type="button" id="exportinexcel" onclick="exportexcel(this)"
                                            value="1"
                                            class="btn btn-warning btn-block btn-md btn-md-global mt-0 print"><i
                                                class="fa fa-file-excel"></i>Export In Excel</button>
                                        <button type='button' class="btn btn-primary btn-block btn-md btn-md-global mt-0 print" value="1"
                                            onclick="exportMonthlyPDF('PDF', '{{ route('hrm.daily_attendance_report_monthly_print') }}')"
                                        ><i class="fa fa-file-pdf"></i> Export Monthly</button>
                                        <button type='button' class="btn btn-success btn-block btn-md btn-md-global mt-0 dailyProcess">Daily Process</button>
                                      {{-- @else --}}
                                           {{-- <button type="button" id="exportinexcel" onclick="exportexcel(this)" value="1"
                                            class="btn btn-warning btn-block btn-md btn-md-global mt-0 printV1"><i
                                            class="fa fa-file-excel"></i>Export In Excel</button>
                                      @endif --}}
                                        {{-- <button type='submit' class="btn btn-primary btn-block btn-md btn-md-global mt-0 print" value="2"><i class="far fa-file-excel"></i> Export EXCEL</button> --}}
                                        {{-- <button type='submit' class="btn btn-success btn-block btn-md btn-md-global mt-0 print" value="3"><i class="fa fa-file-pdf"></i>Night Shift Report</button> --}}
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <div class="card-header"> Daily Attendance Report</div>
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="daily-attend-container">
                        @include('admin.reports.hrm.daily_attendance_report_list_ewmch')
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $("body").addClass("sidebar-collapse");

    $('.select2').select2();
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });

    $(document).on("click", "#dailyAttSearchReport", function(e) {
        var formID = $("#frmSearch").attr("id");
        // var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('hrm/daily_attendance_report_search_ewmch') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#daily-attend-container").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
        e.stopImmediatePropagation();
    });

    $(document).on("click", ".dailyProcess", function(e) {
        if (confirm("Are you sure?")) {
            let from_date = $('#date_pic').val();
            let to_date = $('#date_pic2').val();
            let daily_date = $('#daily_date').val();    
            let card_hidn = $('#card_hidn').val();    
            var formID = $("#frmSearch").attr("id");
            var formMethod = $("#frmSearch").attr("method");
            $.ajax({
                data: {
                    from_date : from_date,
                    to_date : to_date,
                    daily_date : daily_date,
                    card_hidn : card_hidn
                },
                url: "{{ url('hrm/process-attendance-daily-store-v1') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    if (data.title == "Success") {
                            $(".common-modal-notify").modal("show");
                            $(".common-modal-notify .modal-body").html(
                                "<i class='fas fa-stroopwafel fa-spin'></i>"
                            );
                            $(".common-modal-notify .modal-title").html(data.title);
                            $(".common-modal-notify .modal-body").html(data.msg);
                    } else {
                        $(".common-modal-notify-error").modal("show");
                        $(".common-modal-notify-error .modal-title").html(
                            data.title
                        );
                        $(".common-modal-notify-error .modal-body").html(
                            data.msg
                        );
                        }
                },
                complete: function() {
                    $.unblockUI();
                }
            });
            e.stopImmediatePropagation()
        }
    });


    // $(document).on("click", ".printV1", function(e) {
    //     var printV1 = $(this).val();

    //     if (printV1 == 1) {
    //         $('form').attr('action', "{{ route('hrm.daily_attendance_report_printv1') }}");
    //     }
    //     if (printV1 == 2) {
    //         $('form').attr('action', "{{ route('hrm.daily_attendance_report_excel') }}");
    //     }
    // });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();

        if (print == 1) {
            $('form').attr('action', "{{ route('hrm.daily_attendance_report_print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('hrm.daily_attendance_report_excel') }}");
        }
        if (print == 3) {
            $('form').attr('action', "{{ route('hrm.daily_attendance_report_night_shift') }}");
        }
        if (print == 6) {
            $('form').attr('action', "{{ route('hrm.daily_attendance_report_printv1') }}");
        }
    });

    function exportexcel(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#frmSearch").submit();
    }

    function exportPDFIPD(element) {
        console.log('exportPDFIPD')
        $("#hdn_report_type").val("PDF");
        $("#frmSearch").submit();
    }

    function exportMonthlyPDF(element, route) {
        $("#hdn_report_type").val(element);
        $('#frmSearch').attr('action', route);
        $("#frmSearch").submit();
    }


function exportPDF(reportType, route) {
        $("#hdn_report_type").val(reportType);

        $('form').attr('action', route);

        $("#frmSearch").submit();
    }

    function exportexcel(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#frmSearch").submit();
    }

</script>
