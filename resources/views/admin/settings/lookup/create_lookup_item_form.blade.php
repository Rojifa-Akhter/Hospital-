@php

$lookupitem = (isset($lookupitem) && (!empty($lookupitem))) ? $lookupitem : [];

$lookupdata_no_pk = ($lookupitem) ? $lookupitem->lookupdata_no_pk : '';
$lookupdata_code = ($lookupitem) ? $lookupitem->lookupdata_code : '';
$lookupdata_pk_no_parent = ($lookupitem) ? $lookupitem->lookupdata_pk_no_parent : '';

$lookup_no_fk = ($lookupitem) ? $lookupitem->lookup_no_fk : '';
$lookup_name = ($lookupitem) ? $lookupitem->lookup_name : '';
$lookupdata_name = ($lookupitem) ? $lookupitem->lookupdata_name : '';
$lookupdata_name_bangla = ($lookupitem) ? $lookupitem->lookupdata_name_bangla : '';
$lookupdata_desc = ($lookupitem) ? $lookupitem->lookupdata_desc : '';
$serial_no = ($lookupitem) ? $lookupitem->serial_no : '';
$lookupdata_status = ($lookupitem) ? $lookupitem->status : '';

@endphp

<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="create_lookup_item">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-lg-5 col-xl-12">
				<form action="{{ route('lookup.storelookupitem') }}" method="post" id="lookupdata-create">
					@csrf
					<input type="hidden" name="id" value="{{ $lookupdata_no_pk }}">
					<div class="form-group row">
						<label for="lookup_no" class="col-sm-12 col-form-label col-form-label-sm">Lookup No <span class="text-danger">*</span></label>
						<div class="col-sm-12">
							<select class="form-control font_size_12 m-auto  required select2" id="lookup_no" name="lookup_no" required>
								<option selected="selected" value="" disabled>Select Lookup No</option>
								@if(!empty($lookup))
								@foreach ($lookup as $record)
									<option value="{{ $record->lookup_no_pk }}"  @if($record->lookup_no_pk == $lookup_no_fk ) selected @endif>{{ $record->lookup_name }}</option>
								@endforeach
								@endif
							</select>
						</div>


						<label for="lookup_data_no" class="col-sm-12 col-form-label col-form-label-sm">Lookup Parent No </label>
						<div class="col-sm-12">
							<select class="form-control font_size_12 m-auto select2" id="lookup_data_no" name="lookup_data_no">
								<option selected="selected" value="" disabled>Select</option>
								@if(!empty($lookup_data))
								@foreach ($lookup_data as $record)
									<option value="{{ $record->lookupdata_no_pk }}"  @if($record->lookupdata_no_pk == $lookupdata_pk_no_parent ) selected @endif>{{ $record->lookupdata_name }}</option>
								@endforeach
								@endif
							</select>
						</div>


						<label for="list_UID" class="col-sm-12 col-form-label col-form-label-sm">List UID <span class="text-danger">*</span></label>
						<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm required" id="list_UID" name="list_UID" value="{{ $lookupdata_code }}" placeholder="Enter List UID" required>
						</div>
					</div>

					<div class="form-group row">
						<label for="lookup_list_name" class="col-sm-12 col-form-label col-form-label-sm">Lookupdata Name <span class="text-danger">*</span></label>
						<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm required" id="lookup_list_name" name="lookup_list_name" value="{{ $lookupdata_name }}" placeholder="Enter lookup List Name" required>
						</div>


						<label for="lookup_name_bangla" class="col-sm-12 col-form-label col-form-label-sm">Lookup Name (বাংলা)</label>
						<div class="col-sm-12">
							<input type="text" class="form-control form-control-sm" id="lookup_name_bangla" name="lookup_name_bangla" value="{{$lookupdata_name_bangla}}" placeholder="Enter Lookup Name (বাংলা)">
						</div>




						<label for="lookup_list_description" class="col-sm-12 col-form-label col-form-label-sm">Lookupdata Description</label>
						<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm" id="lookup_list_description" name="lookup_list_description" value="{{ $lookupdata_desc }}" placeholder="Enter Lookup List Description">
						</div>
					</div>

					<div class="form-group row">
						<label for="lookup_serial" class="col-sm-12 col-form-label col-form-label-sm">Serial No <span class="text-danger">*</span></label>
						<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm" id="lookup_serial" name="lookup_serial" value="{{ $serial_no }}" placeholder="0" required>
						</div>

						<label for="lookup_status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
						<div class="col-md-4">
							<div class="form-check form-check-inline">
		                     	<input class="form-check-input" type="checkbox" name=" lookup_status" id="lookup_status" value="1" {{ $lookupdata_status == '1' ? 'checked' : '' }}>
		                     	<label class="form-check-label" for="lookup_status">Active</label>
		                    </div>
						</div>
					</div>

                    <div class="modal-footer mt-1">
                    	@php
                    	$response_action = route('lookup.indexlookupitem');
                    	@endphp


                    	<div class="col-md-12 mt-4">
                    		<button type="submit" class="btn btn-md btn-success"onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                    		<button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
                    		<button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$(function() {
		$("#category_lookup").focus();
		$('.select2').select2();
	});
</script>

