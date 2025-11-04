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
                <h5 class="mt-2 mb-0">Corporate Financial Report</h5>
                <small>Report / Corporate Financial Report</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <form id="corporate_financialSearchForm" method="post" action="{{ route('corporate-report-pdf') }}">
                    @csrf

                    <input type="hidden" id="print_type" name="print_type" value="">
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="patient_id">Patient ID </label>
                            <input type="text" class="form-control" name="patient_id" id="patient_id"
                                autocomlete="off" placeholder="Patient ID" />
                            <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                        </div>
                        {{-- <div class="col-md-3">
							<label for="referral_doctor">Doctor </label>
							<input type="text" class="form-control" id="primary_doctor" name="primary_doctor" placeholder="Doctor Code">
							<input type="hidden" class="form-control" id="hdn_doctor_id" name="hdn_doctor_id" >
						</div> --}}
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6" style="margin-right: -30px;">
                                    <label for="type">From</label>
                                    <input type="text" class="form-control date_picker" name="date_from"
                                        value="" id="date_from" autocomlete="off" placeholder="From Date" />
                                </div>
                                <div class="col-md-6">
                                    <label for="type">To </label>
                                    <input type="text" class="form-control date_picker" name="date_to" value=""
                                        id="date_to" autocomlete="off" placeholder="To Date" />
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-3">
                            <button type="button" id="corporate_search"
                                class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                            <button type="submit" id="finc_report"
                                class="btn btn-md btn-primary mt-4 print btn-md-global"> Export PDF</button>
                            <button type="submit" id="summary" class="btn btn-md btn-primary btn-block mt-4 print"
                                data-type="Summary"> Export Total PDF</button>


                        </div> --}}


                        <div class="col-md-4">
							<div class="btn-group btn-block" role="group">
								<button type="button" id="corporate_search"  class="btn btn-md btn-success btn-block mt-4">Search</button>
								<button type="submit" id="finc_report"  class="btn btn-md btn-primary btn-block mt-4 print"> Export PDF</button>
								<button type="submit" id="summary"  class="btn btn-md btn-primary btn-block mt-4 print" data-type="Summary"> Export Total PDF</button>

							</div>
						</div>


                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5>Corporate Financial Details List</h5>
            </div>
            <div class="card-body">
                <div class="mt-2" id="corporate_financial_report">
                    @include('admin.reports.ipd.financial.corporate_report_table')
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
