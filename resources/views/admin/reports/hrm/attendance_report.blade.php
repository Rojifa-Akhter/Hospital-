<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Attendance Report</h5>
                <small>Report / HRM / Attendance Report</small>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header ">
                <h5> Search</h5>
            </div>

           <div class="row">
            <div class="col-md-12">
                <div class="card-body ">
                    <div class="form-row mt-2">
                        <div class="col-md-12 ">
                            <form method="post" id="frmSearch" action=""
                                data-response-action="" target="_blank">
                                @csrf
                                <div class="form-group  form-row d-flex justify-content-around">
                                    <input type="hidden" name="id" value="">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">Date</label>
                                    <div class=" col-md-2">
                                        <input type="text" class="form-control form-control-sm date_picker" id="date_pic"
                                            name="date_pic" value="{{ date('d-m-Y') }}" placeholder="YYYY/DD/MM">
                                        <span class="focus_input"></span>
                                    </div>
                                    <label for="card_no" class=" col-form-label col-form-label-sm ">Card No</label>
                                    <div class=" col-md-2 ">
                                        <input type="text" class="form-control form-control-sm " id="card_no" name="card_no"
                                            value="" placeholder="Cord no">
                                        <input type="hidden" name="card_hidn" id="card_hidn">

                                    </div>

                                    <div class="col-md-6">
                                        <div class="btn-group btn-block" role="group">
                                            <button type="button" class="btn btn-md btn-success btn-md-global btn-block mt-0"
                                                id="attendanceReport" onclick=""> <i class="fas fa-search"></i>
                                                Search</button>
                                            <button type='submit' class="btn btn-info btn-block btn-md-global btn-md mt-0 print"
                                                value="1"><i class="fa fa-file-pdf"></i> Export PDF</button>
                                            <button type='submit' class="btn btn-primary btn-block btn-md btn-md-global mt-0 print"
                                                value="2"><i class="far fa-file-excel"></i> Export EXCEL</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           </div>
        </div>
    </div>


    <div class="container-fluid">

        <div class="card">
            <div class="card-header">Attendance Report</div>
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="attendance-container">
                        @include('admin.reports.hrm.attendance_report_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,


    });

    $(document).on("click", "#attendanceReport", function(e) {
        var formID = $("#frmSearch").attr("id");
        // var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('hrm/attendance_report_search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#attendance-container").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();

        if (print == 1) {
            $('form').attr('action', "{{ route('hrm.attendance_report_print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('hrm.attendance_report_excel') }}");
        }
    });
</script>
