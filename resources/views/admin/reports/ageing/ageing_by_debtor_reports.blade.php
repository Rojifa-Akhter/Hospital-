<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<section id="report_section">
    <div class="container-fluid">
        <!-- Header -->
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">AGEING BY DEBTOR REPORT</h5>
                <small>Report / AGEING BY DEBTOR REPORT</small>
            </div>
        </div>

        <!-- Search Form -->
        <div class="card mt-2">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form id="searchFormAgeingDebtor" method="post" target="_blank"
                    action="{{ route('ageing-by-debtor-report-pdf') }}">
                    @csrf
                    <div class="form-row justify-content-center">
                        <!-- Date Picker -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Date</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm date_picker"
                                        id="date" name="date" value="{{ date('d/m/Y') }}"
                                        placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <!-- Patient Type -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="patient_type">Patient Type</label>
                                <select name="patient_type" id="patient_type" class="form-control form-control-sm">
                                    <option value="">All Types</option>
                                    @foreach ($patient_types as $type)
                                        <option value="{{ $type->patient_type_desc }}">{{ $type->patient_type_desc }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Hidden Report Type -->
                        <input type="hidden" name="hdn_report_type" id="hdn_report_type" value="">

                        <!-- Buttons -->
                        <div class="col-md-8">
                            <div class="btn-group btn-block mt-4" role="group">
                                <button type="button" id="ageing_debtor_search" class="btn btn-success btn-md">
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
                    <div class="col-md-12" id="ageingDebtorData">
                        @include('admin.reports.ageing.ageing_by_debtor_report_data')
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
    $(document).on("click", "#ageing_debtor_search", function() {
        $.ajax({
            url: "{{ route('ageing-by-debtor-report-search') }}",
            type: "POST",
            data: $("#searchFormAgeingDebtor").serialize(),
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#ageingDebtorData").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    // Export PDF
    $(document).on("click", "#exportPDF", function() {
        $("#hdn_report_type").val("PDF");
        $("#searchFormAgeingDebtor").submit();
    });

    // Export Excel
    $(document).on("click", "#exportExcel", function() {
        $("#hdn_report_type").val("EXCEL");
        $("#searchFormAgeingDebtor").submit();
    });
</script>
