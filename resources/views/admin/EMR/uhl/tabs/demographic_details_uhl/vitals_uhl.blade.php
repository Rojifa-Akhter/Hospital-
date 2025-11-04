<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

{{--<form id="frmSearch" method="post" action="{{ route('emr.vitals-search') }}">--}}
{{--	<input type="hidden" value="" class="keep_me" name="patient_id" id="hdn_patient_id">--}}
{{--	@csrf--}}
{{--	<div class="form-row justify-content-center mb-3">--}}
{{--		<div class="col-md-3">--}}
{{--			<div class="form-group">--}}
{{--				<label class="col-form-label col-form-label-sm" for="vital_date">Vital Date</label>--}}
{{--				<input type="text" class="form-control form-control-sm m-0 datepicker" id="vital_date" name="vital_date" value="" placeholder="dd/mm/yyyy">--}}
{{--			</div>--}}
{{--		</div>--}}
{{--		<div class="col-md-3">--}}
{{--			<div class="btn-group btn-block" role="group">--}}
{{--				<button type="button" id="btnSearchVitalSearch" class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-search"></i> Search</button>--}}
{{--				<a rel="tab" href="#" class="btn btn-info btn-block btn-md mt-4"><i class="fa fa-redo"></i> Refresh</a>--}}
{{--			</div>--}}
{{--		</div>--}}
{{--	</div>--}}
{{--</form>--}}

<div class="form-row">
	<div class="col-12 table-responsive" >
		<table class="table table-striped table-bordered table-hover mb-0">
			<thead class="bg-primary">
				<tr>
					<th class="text-center">SL</th>
					<th class="text-center">Date</th>
					<th class="text-center">Pulse</th>
					<th class="text-center">BP</th>
					{{-- <th class="text-left">Chief Complaints</th> --}}
					<th class="text-center">Temperature</th>
					<th class="text-center">Height</th>
					<th class="text-center">Weight</th>
					<th class="text-center">BMI</th>
					{{-- <th class="text-center">Dia-Sys</th> --}}
					{{-- <th class="text-center">OFC</th> --}}
					<th class="text-center">Oxygen</th>
					<th class="text-center">Spo2</th>
					<th class="text-center">Respiration</th>
{{--					<th class="text-center">Vital Date</th>--}}
					{{-- <th class="text-left">Prescribed Hospital</th> --}}
				</tr>
			</thead>
			<tbody id="search_data">
				@include('admin.EMR.uhl.tabs.demographic_details_uhl.vitals_data_uhl')
			</tbody>
		</table>
	</div>
</div>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">
    $('.datepicker').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy',
        clearBtn: true,
        autoclose: true
    });
//searching Work


$(document).on("click", "#btnSearchVitalSearch",function(e){
	var formID      = $("#frmSearch").attr("id");
	var formAction  = $("#frmSearch").attr("action");
	var formMethod  = $("#frmSearch").attr("method");
	$.ajax({
		data: $('#'+formID).serialize(),
		url: formAction,
		type: formMethod,
		beforeSend:function(){
			blockUI();

		},
		success: function (data) {
			$("#search_data").html(data);
		},
		complete:function(){
			$.unblockUI();
		}
	});
});




</script>
