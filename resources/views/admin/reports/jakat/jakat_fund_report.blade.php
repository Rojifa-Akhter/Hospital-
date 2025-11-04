<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .sorting {
        background-image: none !important;
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Payment Type Wise Report</h5>
                <small>Report / Payment Type Wise Report</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('ipd.patient-referral-consultant-report-pdf') }}" id="SearchFormRefCon"
                    method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="col-md-2">
                            <label for="pat_type">Payment Type</label>
                            <select class="form-control font_size_12  " id="pat_type" name="pat_type" width="200px">
                                <option value='2'> Admitted Patient </option>
                                <option value='3'> Current Patient </option>
                                <option value='4'> Discharge Patient </option>
                                <option value='5'> Death Patient </option>

                            </select>
                        </div>
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
                        <div class="col-md-4">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="btnSearchRefCon"
                                    class="btn btn-md btn-success btn-block mt-4">Search</button>
                                <button type="submit" id="cashier_report"
                                    class="btn btn-md btn-primary btn-block mt-4 print"> Export PDF</button>

                            </div>
                        </div>
                </form>
            </div>
        </div>
        <div class="card">
			<div class="card-body p-2">
				<div class="form-row">
					<div class="col-md-12" id="date_cashier_wise_data">
						@include('admin.reports.jakat.jakat_fund_report_table')
					</div>
				</div>
			</div>
		</div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    $("body").addClass("sidebar-collapse");

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#btnSearchRefCon", function(e) {
        var formID = $("#SearchFormRefCon").attr("id");
        var formMethod = $("#SearchFormRefCon").attr("method");

        $("#SearchFormRefCon").attr('action',
        "{{ url('ipd-patient-referral-consultant-wise-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('ipd-patient-referral-consultant-wise-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#ipd-patientList").html(data);
                $("#SearchFormRefCon").attr('action',
                    "{{ route('ipd.patient-referral-consultant-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
