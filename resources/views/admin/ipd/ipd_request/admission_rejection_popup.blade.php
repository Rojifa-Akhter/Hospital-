<form id="admission_regection_form" action="{{route('ipd.store-admission-rejection')}}" method="post">
	<input type="hidden" id="hidden_service_no" name="hidden_service_no" value="{{$service_no}}">
	<input type="hidden" id="hidden_admission_req_uid" name="admission_req_uid" value="{{$admission_req_uid}}">
	<div class="col-md-12">
		<label class="col-form-label col-form-label-sm" for="reject_reason">Reject Reason</label>
		<textarea  class="form-control form-control-sm m-0" id="reject_reason" name="reject_reason" value="" placeholder="Reject Reason"> </textarea>
	</div>	
	<div class="m-0 mt-3 text-right">
		@php
		$response_action = route('ipd.admission-cancelled');
		@endphp
		<button type="submit" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
		<button type="reset" class="btn btn-info btn-sm" title="Click here to Clear form data">Clear</button>
		<a href="{{ route('ipd.ipd-admission') }}" class="btn btn-danger btn-sm" rel="tab" title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
	</div>
</form>