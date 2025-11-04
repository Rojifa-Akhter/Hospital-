<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Daily Late Report</h5>
                <small>Report / HRM / Daily Late Report</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-2 ">
                    <div class="card-header ">
                        <h5> Search</h5>
                    </div>

                    <div class="card-body ">
                        <div class="form-row mt-4">
                            <div class="col-md-12  ">
                                <form method="post" id="frmSearch" action="" data-response-action=""
                                    target="_blank">
                                    @csrf
                                    <div class="form-row justify-content-center">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="card_no" class=" col-form-label col-form-label-sm">Card
                                                    No</label>
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="card_no" name="card_no" maxlength="50" value=""
                                                    placeholder="Enter Card No." />
                                                <input type="hidden" id="card_hidn" name="card_hidn" value="" />
                                                <div><strong>
                                                        <p id="autocomplete_data"></p>
                                                    </strong></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="search_date_from">Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="search_date_from" name="search_date_from"
                                                        value="{{ date('d/m/Y') }}" placeholder="dd/mm/yyyy"
                                                        autocomplete="off">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="search_date_to" name="search_date_to"
                                                        value="{{ date('d/m/Y') }}" placeholder="dd/mm/yyyy"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <div class="btn-group btn-block" role="group">
                                                <button type="button"
                                                    class="btn btn-md btn-md-global btn-success btn-block mt-0"
                                                    id="dailyLateReport" onclick=""> <i class="fas fa-search"></i>
                                                    Search</button>
                                                <button type='submit'
                                                    class="btn btn-info btn-block btn-md btn-md-global mt-0 print"
                                                    value="1"><i class="fa fa-file-pdf"></i> Export PDF</button>
                                                <button type='submit'
                                                    class="btn btn-primary btn-block btn-md btn-md-global mt-0 print"
                                                    value="2"><i class="far fa-file-excel"></i> Export
                                                    EXCEL</button>
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
            <div class="card-header">Daily Late Report</div>
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="daily-late-container">
                        @include('admin.reports.hrm.daily_late_report_list')
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
    // SideBar Collapse
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#dailyLateReport", function(e) {
        var formID = $("#frmSearch").attr("id");
        // var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#frmSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('hrm/daily_late_report_search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#daily-late-container").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();

        if (print == 1) {
            $('form').attr('action', "{{ route('hrm.daily_late_report_print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('hrm.daily_late_report_excel') }}");
        }
    });
</script>
