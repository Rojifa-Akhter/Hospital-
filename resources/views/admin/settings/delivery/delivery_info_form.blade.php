<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<div class="row">
	<div class="col-sm-12 col-lg-12 col-xl-12">
		<form action="{{ route('create-delivery') }}" id="assign-deliveryman-form"method="post">
			@csrf

			<input type="hidden" name="order_id" value="{{$order_id}}">
			<div class="form-group row justify-content-center">
				<div class="col-md-12">
					<label for="date" class="col-sm-12 col-form-label col-form-label-sm">Delivery Date<span class="text-danger">*</span></label>
					<div class="col-sm-12">
						<input type="text" autocomplete="off" class="form-control form-control-sm date_picker" id="date_pic" name="date_pic" value="" placeholder="DD-MM-YYYY">
						<span class="focus_input"></span>
					</div>
				</div>

			</div>
			<div class="form-group row justify-content-center">
				<div class="col-md-12">
					<label for="delivery_man" class="col-sm-12 col-form-label col-form-label-sm">Delivery Man<span class="text-danger">*</span></label>
					<div class="col-sm-12">
						<select class="form-control font_size_12 m-auto select2" id="delivery_man" name="delivery_man">
							<option value="" >Select Delivery Man</option>
							@if(!empty($delivery_mans))
							@foreach ($delivery_mans as $record)
							<option value="{{ $record->person_no_pk}}">{{ ucfirst(strtolower($record->full_name)) }}</option>
							@endforeach
							@endif
						</select>
					</div>
				</div>
			</div>



			<div class="modal-footer mt-1 text-left">
				@php
				$response_action = route('admin-unassigned-order-list');
				@endphp
				<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button>
				<button type="button" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Assign</button>

			</div>
		</form>
	</div>
</div>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
	$(function() {

		$('.select2').select2();
	});
	$('.date_picker').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
	});

</script>
