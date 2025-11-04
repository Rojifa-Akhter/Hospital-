@php

$lookup = (isset($lookup) && (!empty($lookup))) ? $lookup : [];

$lookup_no_pk = ($lookup) ? $lookup->lookup_no_pk : '';
$lookup_code = ($lookup) ? $lookup->lookup_code : '';
$lookup_name = ($lookup) ? $lookup->lookup_name : '';
$lookup_desc = ($lookup) ? $lookup->lookup_desc : '';
$lookup_status = ($lookup) ? $lookup->status : '';
$lookup_status = ($lookup) ? $lookup->status : '';
@endphp
<div class="col-sm-12 col-lg-5 col-xl-12">
<form action="{{ route('lookup.store') }}" method="post" id="lookup-create">
	 @csrf
	 <input type="hidden" name="id" value="{{$lookup_no_pk}}">
		<div class="form-group row">
			<label for="lookup_UID" class="col-sm-12 col-form-label col-form-label-sm">Lookup UID <span class="text-danger">*</span></label>
			<div class="col-sm-12">
				<input type="text" class="form-control form-control-sm" id="lookup_UID" name="lookup_UID" value="{{ $lookup_code }}" placeholder="Enter lookup uid" required>
			</div>

			<label for="lookup_name" class="col-sm-12 col-form-label col-form-label-sm">Lookup Name <span class="text-danger">*</span></label>
			<div class="col-sm-12">
				<input type="text" class="form-control form-control-sm" id="lookup_name" name="lookup_name" value="{{ $lookup_name }}" placeholder="Enter lookup Name" required>
			</div>
		</div>

		<div class="form-group row">
			<label for="lookup_description" class="col-sm-12 col-form-label col-form-label-sm">Description</label>
			<div class="col-sm-12">
				<input type="text" class="form-control form-control-sm" id="lookup_description" name="lookup_description" value="{{ $lookup_desc }}" placeholder="Enter lookup Description">
			</div>

			<label for="lookup_status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
			<div class="col-sm-12">
				<div class="form-check form-check-inline">
		         	<input class="form-check-input" type="checkbox" name=" lookup_status" id="lookup_status" value="1" {{ $lookup_status == '1' ? 'checked' : '' }}>
		         	<label class="form-check-label" for="lookup_status">Active</label>
		        </div>	
			</div>
		</div>


        <div class="modal-footer mt-1">
			@php
                $response_action = route('lookup.index');
            @endphp


						 <div class="col-md-12 mt-4">
						<button type="submit" class="btn btn-md btn-success"onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
	              <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
	       		<button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>
		</div>
	</form>
</div>