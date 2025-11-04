<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Daily Pharmacy  sales Summary Report</h5>
                <small>Report / Daily Pharmacy  sales Summary Report</small>
            </div>
        </div>
       
        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('report.pharmacy-daily_summary_report_print') }}" id="searchForm" method="post"
                    target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">
                        {{-- <div class="col-md-2">
                            <div class="form-group">
                                <label for="card_no" class=" col-form-label col-form-label-sm">Cashier Name</label>
                                <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                       name="primary_doctor" maxlength="50" value="" placeholder="Cashier Name"
                                        />
                                <input type="hidden" id="doctor_id" name="doctor_id" value=""/>
                                <div><strong><p id="autocomplete_data"></p></strong></div>
                            </div>
                        </div> --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="card_no" class=" col-form-label col-form-label-sm">Cashier Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                    name="primary_doctor" maxlength="50" value="" placeholder="Cashier Name" />
                                <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                                <div><strong>
                                        <p id="autocomplete_data"></p>
                                    </strong></div>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
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
                        <div class="col-md-1">
                            <div class="form-group">

                                <input type="checkbox" class=" col-form-label col-form-label-sm mt-4" name="due_amt"
                                    id="due_amt" value="1">
                                <label for="due_amt" class=" col-form-label col-form-label-sm mt-4">Due Bill</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">

                                <input type="checkbox" class=" col-form-label col-form-label-sm mt-4" name="ipd_amt"
                                    id="ipd_amt" value="IPD">
                                <label for="ipd_amt" class=" col-form-label col-form-label-sm mt-4">IPD Bill</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">

                                <input type="checkbox" class=" col-form-label col-form-label-sm mt-4" name="opd_amt"
                                    id="opd_amt" value="OPD">
                                <label for="opd_amt" class=" col-form-label col-form-label-sm mt-4">OPD Bill</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">

                                <input type="checkbox" class=" col-form-label col-form-label-sm mt-4" name="all_amt"
                                    id="all_amt" value="ALL">
                                <label for="all_amt" class=" col-form-label col-form-label-sm mt-4">All Bill</label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="btnSearchReport"
                                    class="btn btn-md btn-success btn-block mt-4">Search</button>
                                <button type="submit" id="date_cashier_report" value="1"
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
                    <div class="col-md-12" id="date_cashier_wise_data">
                      
                        @include('admin.reports.date_cashier_wise_search_data_summary')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                format: 'dd/mm/yyyy',
                endDate: '+0d',
            });
        });


        openDoctorAutocomplete('#primary_doctor', 'doctor_id');
        $(document).on("click", "#btnSearchReport", function(e) {
            var formID = $("#searchForm").attr("id");
            var formMethod = $("#searchForm").attr("method");

            $("#searchForm").attr('action', "{{ url('reports/pharmacy/get-daily-summary-report') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('reports/pharmacy/get-daily-summary-report') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#date_cashier_wise_data").html(data);
                    $("#searchForm").attr('action',
                        "{{ route('report.pharmacy-daily_summary_report_print') }}");
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
