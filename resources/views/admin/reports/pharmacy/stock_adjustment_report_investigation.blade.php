<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Item Wise Report</h5>
                <small>Report / Item Wise Report</small>
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-header"><h5><i class="fa fa-search"></i> Search Panel</h5></div>
            <div class="card-body pt-2 bg-light">

                <form id="frmDailysalesSearch" method="post" action="{{ route('report.pharmacy-daily_report_print') }}">
                    @csrf
                    <input type="hidden" name="type" value="Sales">
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="patient_id">Patient ID </label>
                            <input type="text" class="form-control" name="patient_id" id="patient_id" autocomlete="off" placeholder="Patient ID" />
                            <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                        </div>
                        <div class="col-md-3">
                            <label for="invoice_id">Voucher No</label>
                            <input type="text" class="form-control" name="invoice_id" id="invoice_id" placeholder="Voucher No" autocomlete="off" />
                            <input type="hidden" class="form-control" id="hdn_invoice_id" name="hdn_invoice_id" />
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6" style="margin-right: -30px;">
                                    <label for="type">From</label>
                                    <input type="text" class="form-control date_picker" value="" name="date_from" id="date_from" autocomlete="off" placeholder="From Date" />
                                </div>
                                <div class="col-md-6">
                                    <label for="type">To </label>
                                    <input type="text" class="form-control date_picker" value="" name="date_to" id="date_to" autocomlete="off" placeholder="To Date" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="daily_sales_search"  class="btn btn-md btn-success mt-4">Search</button>
                            <button type="submit" id="pharmacy_finc_report"  class="btn btn-md btn-primary mt-4 print"> Export PDF</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> --}}
        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pharmacy.stock-adjustment-investigation-report-pdf') }}" id="stockInvReport"
                    method="post" target="_blank">
                    @csrf
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


                        <div class="col-md-3">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="invStockSearch"
                                    class="btn btn-md btn-success btn-block mt-4">Search</button>
                                <button type="submit" id="date_cashier_report" value="1"
                                    class="btn btn-md btn-primary btn-block mt-4 print "> Export PDF</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="stockInveReportData">
                        @include('admin.reports.pharmacy.stock_adjustment_report_investigation_table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal" tabindex="-1" role="dialog" id="stock_detail_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        // $(function() {
        //     $('.date_picker').datepicker({
        //         todayHighlight: true,
        //         clearBtn: true,
        //         autoclose: true,
        //         format: 'yyyy-mm-dd',
        //         endDate: '+0d',
        //     });
        // });
        $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });


        // $(document).on("click", "#daily_sales_search", function(e) {
        //     var formID = $("#frmDailysalesSearch").attr("id");
        //     var formMethod = $("#frmDailysalesSearch").attr("method");
        //     $("#frmDailysalesSearch").attr('action',"{{ url('reports/pharmacy/get-daily-report') }}");
        //     $.ajax({
        //         data: $('#' + formID).serialize(),
        //         url:"{{ url('reports/pharmacy/get-daily-report') }}",
        //         type: formMethod,
        //         beforeSend: function() {
        //             blockUI();

        //         },
        //         success: function(data) {
        //             $("#Daily-sales-list").html(data);
        //             $("#frmDailysalesSearch").attr('action',"{{ route('report.pharmacy-daily_report_print') }}");
        //         },
        //         complete: function() {
        //             $.unblockUI();
        //         }
        //     });
        // });

        openDoctorAutocomplete('#primary_doctor', 'doctor_id');
        //     $(document).on("click", "#btnSearchReport", function(e) {
        // 	var formID = $("#searchForm").attr("id");
        // 	var formMethod = $("#searchForm").attr("method");

        // 	$("#searchForm").attr('action',"{{ url('reports/pharmacy/get-daily-report') }}");
        // 	$.ajax({
        // 		data: $('#' + formID).serialize(),
        // 		url:"{{ url('reports/pharmacy/get-daily-report') }}",
        // 		type: formMethod,
        // 		beforeSend: function() {
        // 			blockUI();

        // 		},
        // 		success: function(data) {
        // 			$("#date_cashier_wise_data").html(data);
        // 			$("#searchForm").attr('action',"{{ route('report.pharmacy-daily_report_print') }}");
        // 		},
        // 		complete: function() {
        // 			$.unblockUI();
        // 		}
        // 	});
        // });

        $(document).on("click", "#invStockSearch", function(e) {
            var formID = $("#stockInvReport").attr("id");
            var formMethod = $("#stockInvReport").attr("method");
            $("#stockInvReport").attr('action', "{{ url('pharmacy/stock-adjustment-investigation-report-search') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('pharmacy/stock-adjustment-investigation-report-search') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#stockInveReportData").html(data);
                    $("#stockInvReport").attr('action',
                        "{{ route('pharmacy.stock-adjustment-investigation-report-pdf') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });

        openPatientAutocomplete('#patient_id');
        openInvoiceAutocomplete('#invoice_id');
        openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'Y');

        $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });

    });
</script>
