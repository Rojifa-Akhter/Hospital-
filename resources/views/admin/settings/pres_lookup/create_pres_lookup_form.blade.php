@php
$presLookupDetailData = (isset($presLookupDetailData) && (!empty($presLookupDetailData))) ? $presLookupDetailData : [];
$presLookupDetailDataPk = ($presLookupDetailData) ? $presLookupDetailData->pres_lookupdatadtl1_no_pk : '';
$lookupCodeId = ($presLookupDetailData) ? $presLookupDetailData->lookupcodeid: '';
$lookupDataId = ($presLookupDetailData) ? $presLookupDetailData->lookupdataid: '';
$department = ($presLookupDetailData) ? $presLookupDetailData->department : '';
$type = ($presLookupDetailData) ? $presLookupDetailData->type : '';
$status = ($presLookupDetailData) ? $presLookupDetailData->status : '';
$detailData = ($presLookupDetailData) ? $presLookupDetailData->detaildata : '';
@endphp

<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<div class="row">
	<div class="col-sm-12 col-lg-12 col-xl-12">
		<form action="{{ route('preslookupdetaildata.store') }}" method="post" id="pressLookup-create">
			@csrf

			<input type="hidden" name="id" value="{{$presLookupDetailDataPk}}">
			<div class="form-group row">
				<div class="col-md-6">
					<label for="lookup_code" class="col-sm-12 col-form-label col-form-label-sm">Lookup Code<span class="text-danger">*</span></label>
					<div class="col-sm-12">
						<select class="form-control font_size_12 m-auto select2" id="lookup_code" name="lookup_code" onchange = "lookUp.getlookupList(this)" required>
							<option >Select Lookup Code</option>
							@if(!empty($lookup))
							@foreach ($lookup as $record)
							<option value="{{ $record->pres_lookup_no_pk}}" {{$record->pres_lookup_no_pk == $lookupCodeId? 'selected': ''}}>{{ $record->pres_lookup_name }}</option>
							@endforeach
							@endif
						</select>
					</div>
				</div>

				<div id="pres_lookup_data" class="col-md-6">
					@include("admin.settings.pres_lookup.pres_lookup_data_dropdown")
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-6">
					<label for="department" class="col-sm-12 col-form-label col-form-label-sm">Department<span class="text-danger">*</span></label>
					<div class="col-sm-12">
						<select class="form-control font_size_12 m-auto select2" id="department" name="department" required>
							<option selected="selected" value="">Select Department</option>
							@if(!empty($serviceUnit))
							@foreach ($serviceUnit as $record)
							<option value="{{ $record->serviceunit_no_pk}}" {{$record->serviceunit_no_pk == $department? 'selected': ''}}>{{ $record->serviceunit_name}}</option>
							@endforeach
							@endif
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<label for="type" class="col-sm-12 col-form-label col-form-label-sm">Type<span class="text-danger">*</span></label>
					<div class="col-sm-12">
						<select class="form-control font_size_12 m-auto select2" id="type" name="type" required>
							<option selected="selected" value="">Select type</option>
							<option value="text" {{ $type=='text'? 'selected': '' }}>Text</option>
							<option value="checkbox" {{ $type=='checkbox'? 'selected': '' }}>CheckBox</option>
							<option value="list" {{ $type=='list'? 'selected': '' }}>List</option>
							<option value="date"  {{ $type=='date'? 'selected': '' }}>Date</option>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-6">
					<label for="detail_data" class="col-sm-12 col-form-label col-form-label-sm">Detail Data</label>
					<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm" id="detail_data" name="detail_data" value = "{{$detailData ? $detailData :''}}" placeholder = "Enter Description">
					</div>
				</div>
				<div class="col-md-6">
					<label for="status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
					<div class="col-md-4">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name=" status" id="status" value="1" {{ $status == '1' ? 'checked' : '' }}>
							<label class="form-check-label" for="status">Active</label>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer mt-1 text-left">
				@php
				$response_action = route('preslookupdetaildata.index');
				@endphp
				<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button>
				<button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save changes</button>
			</div>
		</form>
	</div>
</div>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
	$(function() {

		$('.select2').select2();
	});
	var lookUp = {
		getlookupList:function (thisElement) {
			var lookupCodeId = $('#lookup_code').val();

			$.ajax({
				url:"{{route('lookupCodeId')}}",
				type:'POST',
				data: {
					lookupCodeId:lookupCodeId
				},
				beforeSend: function () {
					blockUI();
				},
				success: function (data) {
					$('#pres_lookup_data').html(data);
				},
				complete: function () {

					$.unblockUI();
				}
			});
		},
	};

</script>
