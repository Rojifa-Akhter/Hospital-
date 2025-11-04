<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Employee Performance Report</h5>
                <small>Reports / Employee Performance Report</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
            <div class="card-body">
                <form action="{{route('hrm.employee_performance_search_data_print')}}" id="searchForm" method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" value="" placeholder="yyyy-mm-dd" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" value="" placeholder="yyyy-mm-dd" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <label for="card_no" class=" col-form-label col-form-label-sm mt-4">Card No</label>
                        <div class=" col-md-2 mt-4">
                            <input type="text" class="form-control form-control-sm " id="card_no" name="card_no"
                                   value="" placeholder="Card no">
                            <input type="hidden" name="card_hidn" id="card_hidn">

                        </div>
                        <div class="col-md-4">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="btnSearchReport"  class="btn btn-md btn-success btn-block mt-4">Search</button>
                                <button type="submit" id="employee_performance_report" value="1"  class="btn btn-md btn-primary btn-block mt-4 print"> Export PDF</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="employee_performance_table">
                        @include('admin.reports.hrm.employee_performance_search_data')
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
            autoclose: true
        });
    });

    $(document).on("click", "#btnSearchReport", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");

        $("#searchForm").attr('action',"{{ url('hrm/employee_performance_search_data') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{ url('hrm/employee_performance_search_data') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#employee_performance_table").html(data);
                $("#searchForm").attr('action',"{{ route('hrm.employee_performance_search_data_print') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

</script>
