
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<div class="row">
	<div class="col-sm-12 col-lg-12 col-xl-12">
		<form action="{{ route('team-build.store') }}" method="post" id="team-build-id">
			@csrf

			<input type="hidden" name="team" value="{{$team_id}}">
			<div class="form-group row">
				<div class="col-md-6">
					<label for="item_type_Code" class="col-sm-12 col-form-label col-form-label-sm">Employee Name<span class="text-danger">*</span></label>
					<div class="col-sm-12">
						<select class="form-control font_size_12 m-auto select2" id="employee" name="employee">
							<option selected="selected" value="">Select Employee Name</option>
							@if(!empty($employees))
							@foreach ($employees as $record)
							<option value="{{ $record->person_no_pk}}" >{{ ucfirst(strtolower($record->full_name))}}</option>
							@endforeach
							@endif
						</select>
					</div>

				</div>
				<div class="col-md-6">
					<label for="item_type_Code" class="col-sm-12 col-form-label col-form-label-sm">Area Name<span class="text-danger">*</span></label>
					<div class="col-sm-12">
						<select class="form-control font_size_12 m-auto select2" id="area" name="area">
							<option selected="selected" value="">Select Area Name</option>
							@if(!empty($areas))
							@foreach ($areas as $id => $area_name)
							<option value="{{ $id }}" >{{ ucfirst(strtolower($area_name))}}</option>
							@endforeach
							@endif
						</select>
					</div>
				</div>

			</div>

			<div class="form-group row">

				<div class="col-md-6">
					<label for="status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
					<div class="col-md-4">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="status" id="status" value="1">
							<label class="form-check-label" for="status">Active</label>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer mt-1 text-left">

				@php
				$response_action = route('sales-team-members');
				@endphp
				<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button>
				<button type="button" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save changes</button>

			</div>
		</form>
	</div>
</div>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
	$(function() {

		$('.select2').select2();
	});


</script>
