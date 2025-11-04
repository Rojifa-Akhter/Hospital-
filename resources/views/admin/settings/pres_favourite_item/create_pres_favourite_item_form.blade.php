@php
$presFavItem = (isset($presFavItem) && (!empty($presFavItem))) ? $presFavItem : [];
$presFavItemPk = ($presFavItem) ? $presFavItem->pres_fav_no_pk : '';
$suNoFk = ($presFavItem) ? $presFavItem->su_no_fk : '';
$personNoFk = ($presFavItem) ? $presFavItem->doctor_person_no_fk : '';
$presLookupNoFk = ($presFavItem) ? $presFavItem->pres_lookup_no_fk: '';
$status = ($presFavItem) ? $presFavItem->status : '';
$favouriteName = ($presFavItem) ? $presFavItem->favourite_name : '';

@endphp

<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<div class="row">
	<div class="col-sm-12 col-lg-12 col-xl-12">
		<form action="{{ route('prescription-favourite-item.store') }}" method="post" id="pres-favourite-item-create">
			@csrf

			<input type="hidden" name="id" value="{{$presFavItemPk}}">
			<div class="form-group row">
				<div class="col-md-6">
					<label for="lookup_code" class="col-sm-12 col-form-label col-form-label-sm">Department<span class="text-danger">*</span></label>
					<div class="col-sm-12">
						<select class="form-control font_size_12 m-auto select2" id="department_id" name="department" onchange = "dept.getlookupList(this)" required>
							<option >Select Department</option>
							@if(!empty($department))
							@foreach ($department as $record)
							<option value="{{ $record->serviceunit_no_pk}}" {{$record->serviceunit_no_pk == $suNoFk? 'selected': ''}}>{{ ucfirst(strtolower($record->serviceunit_name)) }}</option>
							@endforeach
							@endif
						</select>
					</div>
				</div>
				<div id="doctor_id" class="col-md-6">
					@include("admin.settings.pres_favourite_item.doctor_dropdown")
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-6">
					<label for="item_type_Code" class="col-sm-12 col-form-label col-form-label-sm">Item Type Code<span class="text-danger">*</span></label>
					<div class="col-sm-12">
						<select class="form-control font_size_12 m-auto select2" id="item_type_code" name="item_type_code" required>
							<option selected="selected" value="">Select Item Type Code</option>
							@if(!empty($itemTypeCode))
							@foreach ($itemTypeCode as $record)
							<option value="{{ $record->pres_lookup_no_pk}}" {{$record->pres_lookup_no_pk == $presLookupNoFk? 'selected': ''}}>{{ ucfirst(strtolower($record->pres_lookup_code))}}</option>
							@endforeach
							@endif
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<label for="favourit_name" class="col-sm-12 col-form-label col-form-label-sm">Favourite Name</label>
					<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm" id="favourit_name" name="favourite_name" value = "{{$favouriteName ? ucfirst(strtolower($favouriteName)) :''}}" placeholder = "Enter Favourite Name">
					</div>
				</div>
			</div>
			<div class="form-group row">

				<div class="col-md-6">
					<label for="status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
					<div class="col-md-4">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $status == '1' ? 'checked' : '' }}>
							<label class="form-check-label" for="status">Active</label>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer mt-1 text-left">
				@php
				$response_action = route('prescription-favourite-item.index');
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
    var dept = {
    getlookupList:function (thisElement) {
        var departmentId = $('#department_id').val();
        $.ajax({
            url:"{{route('departmentId')}}",
            type:'POST',
            data: {
             departmentId:departmentId
         },
         beforeSend: function () {
            blockUI();
        },
        success: function (data) {
		$('#doctor_id').html(data);
     },
     complete: function () {

        $.unblockUI();
    }
});
    },
};

</script>
