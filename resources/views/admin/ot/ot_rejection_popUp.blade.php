<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('select2/dist/css/select2.min.css')}}">
<form id="ot-reject-form" action="{{ route('ot.store-ot-rejection-popUp') }}" method="post">
	<div class="form-row">
		<input type="hidden" id="hidden_ot_req_no_pk" name="hidden_ot_req_no_pk" value="{{$ot_req_no_pk}}">
		<div class="col-md-12">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="rejected_by">Rejected By</label>
				<select class="form-control form-control-sm select2" id="rejected_by" name="rejected_by">
					<option value="">Choose Rejected By</option>
					@if($reject_by)
						@foreach($reject_by as $rej_by)
							<option value="{{$rej_by->person_no_pk}}">{{$rej_by->full_name}}</option>
						@endforeach
					@endif
				</select>
			</div>

			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="reject_note">Reject Note</label>
				<textarea  class="form-control form-control-sm m-0" id="reject_note" name="reject_note" value="" placeholder="Reject Note"> </textarea>
			</div>
		</div>
	</div>

	<div class="m-0 pt-2 text-right border-top">
		@php
			$response_action = route('ot.requisition-status');
			// $response_action = route('ot.ot-rejected');
		@endphp
		<button type="submit" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
		<button type="reset" class="btn btn-info btn-sm" title="Click here to Clear form data">Clear</button>
		<a href="{{ $response_action }}" class="btn btn-danger btn-sm" rel="tab" title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
	</div>
</form>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('select2/dist/js/select2.min.js')}}"></script>
<script>
    $(document).ready(function () {
		$('.select2').select2({});
    })
</script>
            