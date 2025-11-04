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
                        <form method="post" id="frmSearch" data-response-action=""
                            action="{{ route('hrm.individual_daily_attendance_report_printv1') }}" target="_blank">
                            @csrf
                            <div class=" justify-content-center  form-row">
                                <input type="hidden" name="id" value="">

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

                                <input type="hidden" value="EXCEL" name="hdn_report_type" id="hdn_report_type">

                                <div class="col-lg-7 col-md-6 text-center mt-4">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button"
                                            class="btn btn-md btn-success btn-md-global btn-block mt-0"
                                            id="dailyAttSearchReport" onclick=""> <i class="fas fa-search"></i>
                                            Search</button>
                                            
                                            <button type='submit'
                                            class="btn btn-info btn-block btn-md btn-md-global mt-0 print"
                                            value="1" onclick="exportPDFIPD()"><i class="fa fa-file-pdf"></i>
                                            Export PDF</button>

                                        <button type="button" id="exportinexcel" onclick="exportexcel(this)"
                                            value="1"
                                            class="btn btn-warning btn-block btn-md btn-md-global mt-0 print"><i
                                                class="fa fa-file-excel"></i> Export In Excel</button>
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
                        @include('admin.reports.hrm.individual_daily_attendance_report_list')
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
        console.log(formID);

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('hrm/daily_attendance_report_search_individual') }}",
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


    // $(document).on("click", ".print", function(e) {
    //     var print = $(this).val();

    //     if (print == 1) {
    //         $('form').attr('action', "{{ route('hrm.daily_attendance_report_print') }}");
    //     }
    //     if (print == 2) {
    //         $('form').attr('action', "{{ route('hrm.daily_attendance_report_excel') }}");
    //     }
    //     if (print == 3) {
    //         $('form').attr('action', "{{ route('hrm.daily_attendance_report_night_shift') }}");
    //     }
    //     if (print == 6) {
    //         $('form').attr('action', "{{ route('hrm.daily_attendance_report_printv1') }}");
    //     }
    // });

    function exportexcel(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#frmSearch").submit();
    }

    function exportPDFIPD(element) {
        console.log('exportPDFIPD')
        $("#hdn_report_type").val("PDF");
        $("#frmSearch").submit();
    }

</script>
