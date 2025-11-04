<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">OPD Invoice Wise Due Report</h5>
                <small>Report / OPD Invoice Wise Due Report</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('opd-invoice-wise-report-pdf') }}" id="ipd_due_form" method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="form-row justify-content-center">

                            <div class="col-sm-2">
                                <label for="patient_id">Patient </label>
                                <input type="text" class="form-control" id="patient_id" name="patient_id"
                                    placeholder="Patient ID/Name/Mobile" title="Search By Patient ID/ Name/ Mobile" />
                                <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                            </div>
                            <div class="col-sm-2">
                                <label for="app_date">Invoice ID</label>
                                <input type="text" class="form-control " name="invoice_id" id="app_date"
                                    autocomlete="off" placeholder="Invoice ID" />
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="search_date_from">Invoice
                                        Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_from" name="search_date_from" value=""
                                            placeholder="dd/mm/yyyy" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_to" name="search_date_to" value=""
                                            placeholder="dd/mm/yyyy" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" id="ipd_search_due_btn"
                                        class="btn btn-md btn-success btn-block mt-4">Search</button>
                                    <button type="submit" id="cashier_report"
                                        class="btn btn-md btn-primary btn-block mt-4 print"> Export PDF</button>

                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="ipd_search_due_data">
                        @include('admin.ipd.reports.opd_invoice_wise_due_report_data')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
    openInvoiceAutocomplete("#app_date");
    openPatientAutocomplete('#patient_id');
    $(document).ready(function() {
        $('.select2').select2();
    });

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#ipd_search_due_btn", function(e) {
        var formID = $("#ipd_due_form").attr("id");
        var formMethod = $("#ipd_due_form").attr("method");
        $("#ipd_due_form").attr('action', "{{ url('opd-invoice-wise-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('opd-invoice-wise-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#ipd_search_due_data").html(data);
                $("#ipd_due_form").attr('action', "{{ route('opd-invoice-wise-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
