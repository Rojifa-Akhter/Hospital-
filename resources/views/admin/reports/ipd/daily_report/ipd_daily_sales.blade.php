<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Ipd Daily sales Report</h5>
                <small>Report / Ipd Daily sales Report</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5><i class="fa fa-search"></i> Search Panel</h5></div>
            <div class="card-body pt-2 bg-light">

                <form id="ipdFrmDailysalesSearch" method="post" action="{{ route('report.daily_report_print_ipd') }}" target="_blank">
                    @csrf
                    <input type="hidden" name="type" value="Sales">
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="patient_id">Patient ID </label>
                            <input type="text" class="form-control" name="patient_id" id="patient_id" autocomlete="off" placeholder="Patient ID" />
                            <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                        </div>
{{--                        <div class="col-md-3">--}}
{{--                            <label for="invoice_id">Voucher No</label>--}}
{{--                            <input type="text" class="form-control" name="invoice_id" id="invoice_id" placeholder="Voucher No" autocomlete="off" />--}}
{{--                            <input type="hidden" class="form-control" id="hdn_invoice_id" name="hdn_invoice_id" />--}}
{{--                        </div>--}}
                        <div class="col-md-6">
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
                            <button type="button" id="ipd_daily_sales_search"  class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                            <button type="submit" id="finc_report"  class="btn btn-md btn-primary mt-4 print btn-md-global"> Export PDF</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header "><h5>Daily sales</h5></div>
            <div class="card-body">
                <div class="row mt-2" id="Daily-sales-list">
                    @include('admin.reports.ipd.daily_report.ipd_daily_report_table')
                </div>

            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>

    $(document).ready(function () {
        $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                format:'dd/mm/yyyy',
                endDate: '+0d',
            });
        });


        $(document).on("click", "#ipd_daily_sales_search", function(e) {
            var formID = $("#ipdFrmDailysalesSearch").attr("id");
            var formMethod = $("#ipdFrmDailysalesSearch").attr("method");
            $("#ipdFrmDailysalesSearch").attr('action',"{{ url('/reports/get-daily-report/ipd') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url:"{{ url('/reports/get-daily-report/ipd') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#Daily-sales-list").html(data);
                    $("#ipdFrmDailysalesSearch").attr('action',"{{ route('report.daily_report_print_ipd') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });


        openPatientAutocomplete('#patient_id');
        openInvoiceAutocomplete('#invoice_id');
        openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'Y');

    });
</script>
