<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">LOHS Report</h5>
				<small>Report / LOHS Report</small>
			</div>
		</div>

		<div class="card">
			<div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
			<div class="card-body">
				<form action="{{ route('lohs-report-pdf') }}" id="lohs_form" method="post">
					@csrf

                    <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
					<div class="form-row justify-content-center">
                        <div class="form-row justify-content-center">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="card_no" class=" col-form-label col-form-label-sm">Admission ID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="admission_id"
                                           name="admission_id" maxlength="50" value="" placeholder="Enter Admission ID" />
                                    <input type="hidden" id="hdn_admission_id" name="hdn_admission_id" value=""/>
                                </div>
                            </div>
                            <div class=" col-md-2">
                                <label for="request_department"
                                    class=" col-form-label col-form-label-sm ">Department</label>
                                <select class="form-control form-control-sm select2" id="request_department"
                                    name="request_department">
                                    <option value="">Select Department</option>
                                    @if (!empty($serviceDepts))
                                        @foreach ($serviceDepts as $rd)
                                            <option value="{{ $rd->serviceunit_no_pk }}">
                                                {{ $rd->serviceunit_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="search_date_from">Admission Date</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">From</div>
									</div>
									<input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" value="{{date('d/m/Y')}}" placeholder="dd/mm/yyyy" autocomplete="off">
									<div class="input-group-prepend">
										<div class="input-group-text">To</div>
									</div>
									<input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" value="{{date('d/m/Y')}}" placeholder="dd/mm/yyyy" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="btn-group btn-block" role="group">
								<button type="button" id="lohs_search_btn"  class="btn btn-md btn-success btn-block mt-4">Search</button>
								<button type="submit" id="lohs_report"  class="btn btn-md btn-primary btn-block mt-4 print"  target="_blank"
                                        onclick="exportPDF()"> Export PDF</button>
								<button type="submit" id="lohs_avg_report"  class="btn btn-md btn-warning btn-block mt-4 print"  onclick="exportAvgPdf(this)"> Export Average PDF</button>

							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="card">
			<div class="card-body p-2">
				<div class="form-row">
					<div class="col-md-12" id="lohs_report_data">
						@include('admin.ipd.reports.lohs_report_search_data')
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">

openAdmissionAutocomplete('#admission_id');

	$(function() {
		$('.date_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            endDate: '+0d',
            'format':'dd/mm/yyyy'
		});
	});

	$(document).on("click", "#lohs_search_btn", function(e) {
		var formID = $("#lohs_form").attr("id");
		var formMethod = $("#lohs_form").attr("method");
		$("#lohs_form").attr('action',"{{ url('lohs-report-search') }}");
		$.ajax({
			data: $('#' + formID).serialize(),
			url:"{{ url('lohs-report-search') }}",
			type: formMethod,
			beforeSend: function() {
				blockUI();

			},
			success: function(data) {
				$("#lohs_report_data").html(data);
				$("#lohs_form").attr('action',"{{ route('lohs-report-pdf') }}");
			},
			complete: function() {
				$.unblockUI();
			}
		});
	});

    function exportPDF(element) {
        $("#hdn_report_type").val("PDF");
        $("#lohs_form").submit();
    }

    function exportAvgPdf(element) {
        $("#hdn_report_type").val("AVGPDF");
        $("#lohs_form").submit();
    }

</script>
