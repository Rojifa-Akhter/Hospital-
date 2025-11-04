@php
$delivery_man = (isset($delivery_man) && (!empty($delivery_man))) ? $delivery_man : [];
$person_no_pk = ($delivery_man) ? $delivery_man->person_no_pk : '';
$person_code = ($delivery_man) ? $delivery_man->person_code : '';
$name = ($delivery_man) ? $delivery_man->full_name : '';
$mobile = ($delivery_man) ? $delivery_man->phone_mobile: '';
$status = ($delivery_man) ? $delivery_man->status : '';
@endphp
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<div class="row">
	<div class="col-sm-12 col-lg-12 col-xl-12">
		<form action="" method="post" id="pres-favourite-item-create">
			@csrf

			<input type="hidden" name="id" value="{{$person_no_pk}}">
			<div class="form-group row">
				<div class="col-md-6">
					<label for="delivery_man_id" class="col-sm-12 col-form-label col-form-label-sm">Id<span class="text-danger">*</span></label>
					<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm" name="delivery_man_id" value = "{{$person_code ? $person_code :''}}" placeholder = "Enter Delivery Men Id ">
					</div>
				</div>
				<div  class="col-md-6">
					<label for="delivery_man_name" class="col-sm-12 col-form-label col-form-label-sm">Name<span class="text-danger">*</span></label>
					<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm" name="delivery_man_name" value = "{{$name ? $name :''}}" placeholder = "Enter Delivery Men Name ">
					</div>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-6">
					<label for="item_type_Code" class="col-sm-12 col-form-label col-form-label-sm">Mobile No<span class="text-danger">*</span></label>
					<div class="col-sm-12">
						<input type="text" class="form-control form-control-sm" name="mobile_no" value = "{{$mobile ? $mobile :''}}" placeholder = "Enter Mobile No">

					</div>
				</div>
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
