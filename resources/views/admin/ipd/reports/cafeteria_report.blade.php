<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Cafeteria Report</h5>
				<small>Report / Cafeteria Report</small>
			</div>
		</div>

		<div class="card">
			<div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
			<div class="card-body">
				<form action="{{ route('cafeteria-report-pdf') }}" id="cafeteria_form" method="post">
					@csrf
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
                            <input type="hidden" id="print_type" name="print_type" value="">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
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
								<button type="button" id="cafeteria_report_search_btn"  class="btn btn-md btn-success btn-block mt-4">Search</button>
								<button type="submit" id="cashier_report"  class="btn btn-md btn-primary btn-block mt-4 print"> Export PDF</button>
								<button type="submit" id="summary"  class="btn btn-md btn-primary btn-block mt-4 print" data-type="Summary"> Export Total PDF</button>

							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="card">
			<div class="card-body p-2">
				<div class="form-row">
					<div class="col-md-12" id="cashier_report_data">
						@include('admin.ipd.reports.cafeteria_report_search_data')
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

	$(document).on("click", "#cafeteria_report_search_btn", function(e) {
        $('#print_type').val('');
		var formID = $("#cafeteria_form").attr("id");
		var formMethod = $("#cafeteria_form").attr("method");
		$("#cafeteria_form").attr('action',"{{ url('cafeteria-report-search') }}");
		$.ajax({
			data: $('#' + formID).serialize(),
			url:"{{ url('cafeteria-report-search') }}",
			type: formMethod,
			beforeSend: function() {
				blockUI();

			},
			success: function(data) {
				$("#cashier_report_data").html(data);
				$("#cafeteria_form").attr('action',"{{ route('cafeteria-report-pdf') }}");
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

</script>
