@php
$delivery_charge = (isset($delivery_charge) && (!empty($delivery_charge))) ? $delivery_charge : [];
$delivery_charge_no_pk = ($delivery_charge) ? $delivery_charge->delivery_charge_no_pk : '';
$delivery_charge_type = ($delivery_charge) ? $delivery_charge->delivery_charge_type : '';
$charge = ($delivery_charge) ? $delivery_charge->delivery_charge : '';
@endphp

<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<div class="row">
	<div class="col-sm-12 col-lg-12 col-xl-12">
		<form action="{{ route('delivery-charge.store') }}" method="post" id="delivery-charge-create">
			@csrf

			<input type="hidden" name="id" value="{{$delivery_charge_no_pk}}">

			<div class="form-group row">
				<div class="col-md-6">
					<label for="delivery_charge_type" class="col-sm-12 col-form-label col-form-label-sm">Delivery Charge Type</label>
					<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm" id="delivery_charge_type" name="delivery_charge_type" value = "{{$delivery_charge_type ? ucfirst(strtolower($delivery_charge_type)) :''}}" placeholder = "Enter Delivery Charge Type">
					</div>
				</div>
				<div class="col-md-6">
					<label for="charge" class="col-sm-12 col-form-label col-form-label-sm">Delivery Charge</label>
					<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm" id="charge" name="charge" value = "{{$charge ? :''}}" placeholder = "Enter Delivery Charge">
					</div>
				</div>
			</div>

			<div class="modal-footer mt-1 text-left">
				@php
				$response_action = route('delivery-charge.index');
				@endphp
				<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button>
				<button type="button" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save changes</button>

			</div>
		</form>
	</div>
</div>

