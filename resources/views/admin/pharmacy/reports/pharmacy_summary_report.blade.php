<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .sorting {
        background-image: none !important;
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Pharmacy Summary Report</h5>
                <small>Report / Pharmacy Summary Report</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <form action="{{ route('report.cashier-wise-report-print') }}" id="searchForm" method="post" target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="form-row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_from" name="search_date_from" value="{{ date('d/m/Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_to" name="search_date_to" value="{{ date('d/m/Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                            <div class="col-md-4">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" id="cashier_report_search"
                                        class="btn btn-md btn-success mt-4">Search</button>
                                    <button type="submit" id="cashier_report"
                                        class="btn btn-md btn-primary mt-4 print" onclick="exportPDFpdf()"> Export PDF</button>
                                    <button type="button" id="summary" class="btn btn-info btn-md mt-4"
                                        onclick="exportPDFSummary()"><i class="fa fa-print"></i> Summary
                                        Report</button>

                                </div>
                            </div>
                        </div>
                </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header ">
            <h5>Pharmacy Summary Report List</h5>
        </div>
        <div class="card-body">
            <div class="mt-2" id="corporate_financial_report">
                @include('admin.pharmacy.reports.pharmacy_summary_report_table')
            </div>
        </div>
    </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                clearBtn: true,
                autoclose: true,
                endDate: '+0d',
            });
        });

        $("#sidebar-left").addClass("active");
        $("#content").addClass("active");

        openPatientAutocomplete('#patient_id');
        openInvoiceAutocomplete('#invoice_id');
        openDoctorAutocomplete('#primary_doctor', 'hdn_doctor_id', 'Y');




        $(document).on("click", "#corporate_search", function(e) {
            var formID = $("#corporate_financialSearchForm").attr("id");
            var formMethod = $("#corporate_financialSearchForm").attr("method");
            $("#corporate_financialSearchForm").attr('action', "{{ url('corporate-report-search') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('corporate-report-search') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#corporate_financial_report").html(data);
                    $("#corporate_financialSearchForm").attr('action',
                        "{{ route('corporate-report-pdf') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });

        $(document).on('click', '#summary', function() {
            console.log($(this).attr("data-type"));
            var pdf = $(this).attr("data-type");
            $('#print_type').val('SUMMARY');


        });


    });
</script>
