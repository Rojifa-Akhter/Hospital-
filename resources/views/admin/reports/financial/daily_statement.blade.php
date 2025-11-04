<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Daily Statement Report</h5>
                <small>Report / Financial / Daily Statement Report</small>
            </div>
        </div>
        <div class="card mt-2" style="width: 100%; margin: auto">
            <div class="card-header ">
                <h5> Search</h5>
            </div>
            <div class="card-body ">
                <div class="form-row mt-2">
                    <div class="col-md-12">
                        <form method="post" id="frmSearch" data-response-action="" action=""  target="_blank">
                            @csrf
                            <div class=" justify-content-center  form-row">
                                <input type="hidden" name="id" value="">



                                <div class=" col-md-2">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From
                                        Date</label>
                                    <input type="text" class="form-control form-control-sm date_picker" id="date_pic"
                                        name="date_pic" value="{{ date('d-m-Y') }}" placeholder="YYYY/DD/MM">
                                    <span class="focus_input"></span>
                                </div>

                                <div class=" col-md-2">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">To
                                        Date</label>
                                    <input type="text" class="form-control form-control-sm date_picker" id="date_pic2"
                                        name="date_pic2" value="{{ date('d-m-Y') }}" placeholder="YYYY/DD/MM">
                                    <span class="focus_input"></span>
                                </div>



                                <div class="col-md-5 text-center mt-4">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-sm btn-success btn-block mt-0"
                                            id="dailyAttSearchReport" onclick=""> <i class="fas fa-search"></i>
                                            Search</button>
                                        <button type='submit' class="btn btn-info btn-block btn-md mt-0 print" value="1"><i class="fa fa-file-pdf"></i> Export PDF</button>

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
            <div class="card-header"> Daily Statement Report</div>
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="daily-attend-container">
                        @include('admin.reports.financial.daily_statement_list')
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
            url: "{{ route('daily-statement-search') }}",
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
    $(document).on("click", ".print", function(e) {
        var print = $(this).val();

        if (print == 1) {
            $('form').attr('action', "{{ route('daily-statement-search-pdf') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('hrm.daily_attendance_report_excel') }}");
        }
    });
</script>
