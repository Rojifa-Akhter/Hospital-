<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<section id="report_section">
    <div class="container-fluid">
        <!-- Header -->
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">SALES REPORT</h5>
                <small>Report / SALES REPORT</small>
            </div>
        </div>

        <!-- Search Form -->
        <div class="card mt-2">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form id="searchFormSalesReport" method="post" target="_blank"
                    action="{{ route('sales-report-pdf') }}">
                    @csrf
                    <div class="form-row justify-content-center">
                        <!-- From Date -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_from">From Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm date_picker"
                                        id="date_from" name="date_from"
                                        value="{{ date('d/m/Y') }}" placeholder="dd/mm/yyyy"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <!-- To Date -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_to">To Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm date_picker"
                                        id="date_to" name="date_to" value="{{ date('d/m/Y') }}"
                                        placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="hdn_report_type" id="hdn_report_type" value="">

                        <!-- Buttons -->
                        <div class="col-md-6 text-center mt-4">
                            <div class="btn-group" role="group">
                                <button type="button" id="sales_report_search" class="btn btn-success btn-md">
                                    <i class="fa fa-search"></i> Search
                                </button>
                                <button type="button" id="exportPDF" class="btn btn-info btn-md">
                                    <i class="fa fa-print"></i> Export PDF
                                </button>
                                <button type="button" id="exportExcel" class="btn btn-primary btn-md">
                                    <i class="fa fa-file-excel"></i> Export Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Report Data -->
        <div class="card mt-2">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="salesReportData">
                        @include('admin.reports.sales.sales_report_data')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">
    $(function() {
        // Initialize datepicker
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            format: 'dd/mm/yyyy'
        });
    });

    // AJAX Search
    $(document).on("click", "#sales_report_search", function() {
        $.ajax({
            url: "{{ route('sales-report-search') }}",
            type: "POST",
            data: $("#searchFormSalesReport").serialize(),
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#salesReportData").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    // Export PDF
    $(document).on("click", "#exportPDF", function() {
        $("#hdn_report_type").val("PDF");
        $("#searchFormSalesReport").submit();
    });

    // Export Excel
    $(document).on("click", "#exportExcel", function() {
        $("#hdn_report_type").val("EXCEL");
        $("#searchFormSalesReport").submit();
    });
</script>
