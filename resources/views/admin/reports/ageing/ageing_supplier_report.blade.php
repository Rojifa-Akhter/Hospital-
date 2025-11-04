<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<section id="report_section">
    <div class="container-fluid">
        <!-- Header -->
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">AGEING SUPPLIER REPORT</h5>
                <small>Report / AGEING SUPPLIER REPORT</small>
            </div>
        </div>

        <!-- Search Form -->
        <div class="card mt-2">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form id="searchFormAgeingSupplier" method="post" target="_blank"
                    action="{{ route('ageing-supplier-report-pdf') }}">
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

                        <!-- Supplier Dropdown -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="supplier_id">Supplier</label>
                                <select class="form-control form-control-sm select2" name="supplier_id" id="supplier_id">
                                    <option value="">All Suppliers</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->supplier_no_pk }}">{{ $supplier->sup_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Hidden Report Type -->
                        <input type="hidden" name="hdn_report_type" id="hdn_report_type" value="">

                        <!-- Buttons -->
                        <div class="col-md-4">
                            <div class="btn-group btn-block mt-4" role="group">
                                <button type="button" id="ageing_supplier_search" class="btn btn-success btn-md">
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
                <div id="ageingSupplierData">
                    @include('admin.reports.ageing.ageing_supplier_report_data')
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script type="text/javascript">
    $(function() {
        // Date Picker
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            format: 'dd/mm/yyyy'
        });

        $(document).ready(function() {
            $('.select2').select2();
        });
    });

    // AJAX Search
    $(document).on("click", "#ageing_supplier_search", function() {
        $.ajax({
            url: "{{ route('ageing-supplier-report-search') }}",
            type: "POST",
            data: $("#searchFormAgeingSupplier").serialize(),
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#ageingSupplierData").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    // Export PDF
    $(document).on("click", "#exportPDF", function() {
        $("#hdn_report_type").val("PDF");
        $("#searchFormAgeingSupplier").submit();
    });

    // Export Excel
    $(document).on("click", "#exportExcel", function() {
        $("#hdn_report_type").val("EXCEL");
        $("#searchFormAgeingSupplier").submit();
    });
</script>
