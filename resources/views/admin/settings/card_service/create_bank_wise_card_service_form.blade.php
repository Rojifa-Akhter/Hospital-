<div class="card">
		<form action="{{ route('service-charge-store') }}" method="post" id="bed-charge-create">
			@csrf
			<input type="hidden" name="id" value="">
			<div class="card-body p-2">
				<div class="form-row justify-content-center">
					<div class="form-group col-md-4 m-0 focused">
						<label for="bank_code" class="col-form-label s-12">Bank Code & Name</label>
						<div class="input-group">
							<div class="input-group-prepend w-100">
								<input type="text" class="form-control form-control-sm required" id="bank_code" name="bank_code"value="" placeholder="Code" style="width: 100px;">
								<select class="form-group form-control keep_me" id="bank_name" name="bank_name" required="">
									<option value="">select Bank Name</option>
									@if(!empty($bank)) @foreach($bank as $pk => $bank)
									<option value="{{ $pk }}">{{ $bank }}</option>
									@endforeach @endif
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="card_type" class="col-form-label col-form-label-sm">Card Type</label>
							<select class="form-group form-control keep_me" id="card_type" name="card_type" required="">
								<option value="">select Bank Name</option>
								@if(!empty($card_type)) @foreach($card_type as $pk => $card_type)
								<option value="{{ $pk }}">{{ $card_type }}</option>
								@endforeach @endif
							</select>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
							<label for="service_charge" class="col-form-label col-form-label-sm">Service Charge</label>
							<input type="text" class="form-control form-control-sm text-right number_only" id="service_charge" name="service_charge" value="" placeholder="0.00">
						</div>
					</div>
					<div class="col-md-1">

						@php
						$response_action = route('bank-service-charge-list');
						@endphp
						<button class="btn btn-md btn-success mt-4" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>

					</div>



				</div>
			</div>
		</form>
	</div>