<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Leave Entry Report</h5>
                <small>Report / Leave Entry Report</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
            <div class="card-body">
                <form action="" id="searchForm" method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" value="{{date('m/d/Y')}}" placeholder="yyyy-mm-dd" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" value="{{date('m/d/Y')}}" placeholder="yyyy-mm-dd" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="card_no">Card No</label>
                                <input type="text" class="form-control form-control-sm " id="card_no" name="card_no"
                                       value="" placeholder="Card no">
                                <input type="hidden" name="card_hidn" id="card_hidn">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="btnSearchReport"  class="btn btn-md btn-md-global btn-success btn-block mt-4">Search</button>
                                <button type="submit" id="leave_report"  class="btn btn-md btn-md-global btn-primary btn-block mt-4 print"> Export PDF</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="leave_report_data">
                        @include('admin.reports.hrm.leave-entry-search-data')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
        });
    });


    $(document).on("click", "#btnSearchReport", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");

        $("#searchForm").attr('action',"{{ url('report/date-cashier-wise-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{ url('reports/leave-entry-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#leave_report_data").html(data);
                $("#searchForm").attr('action',"{{ route('report.leave-entry-report-print') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
