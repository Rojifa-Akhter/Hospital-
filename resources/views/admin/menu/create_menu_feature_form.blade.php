@php
$menuFeature = (isset($menuFeature) && (!empty($menuFeature))) ? $menuFeature : [];
$id = ($menuFeature) ? $menuFeature->features_no_pk : '';
$Feature_code = ($menuFeature) ? $menuFeature->features_code : '';
$menu_no_fk = ($menuFeature) ? $menuFeature->menu_no_pk : '';
$feature_name = ($menuFeature) ? $menuFeature->features_name : '';
$sl_no = ($menuFeature) ? $menuFeature->sl_no : '';
$menu_link = ($menuFeature) ? $menuFeature->page_url : '';
$feature_status = ($menuFeature) ? $menuFeature->status : '';
@endphp
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<form method="post" id="frm-menu-store" action="{{ route('menu-feature-store') }}" >
		@csrf
		<input type="hidden" name="id" value="{{$id}}" value="">
	<div class="form-group row">
    <label for="parent_menu" class="col-sm-4 col-form-label col-form-label-sm">Module<span class="text-danger">*</span></label>
		<div class="col-sm-8">
			<select class="form-control font_size_12 m-auto select2" id="module_menu" name="module_menu" >
				<option value="">Select Module Menu</option>
				@if(isset($parent_menu) && $parent_menu->count() > 0 )
					@foreach($parent_menu as $key => $value)
						<option value="{{$value->menu_no_pk}}" {{$menu_no_fk == $value->menu_no_pk ? 'selected' : ''}}>{{$value->menu_name}}</option>
					@endforeach
				@endif
			</select>
		</div>
		<label for="menu_id" class="col-sm-4 col-form-label col-form-label-sm mt-2">Feature Id <span class="text-danger">*</span></label>
		<div class="col-sm-8">
			<input type="text" class="form-control form-control-sm mt-2" id="Features_id" name="Features_id" value="{{$Feature_code}}" placeholder="Enter Menu Id" >
		</div>
	</div>
	<div class="form-group row">
		<label for="menu_name" class="col-sm-4 col-form-label col-form-label-sm"> Features Name <span class="text-danger">*</span></label>
		<div class="col-sm-8">
			<input type="text" class="form-control form-control-sm" id="features_name" name="features_name" value="{{$feature_name}}" placeholder="Enter lookup Name" >
		</div>

		<label for="serial_number" class="col-sm-4 col-form-label col-form-label-sm">Serial Number</label>
		<div class="col-sm-8">
			<input type="text" class="form-control form-control-sm" id="serial_number" name="serial_number" value="{{$sl_no}}" placeholder="Serial Number">
		</div>
	</div>

	<div class="form-group row">
		<label for="page_link" class="col-sm-4 col-form-label col-form-label-sm">Page URL </label>
		<div class="col-sm-8">
			<input type="text" class="form-control form-control-sm" id="page_link" name="page_link" value="{{$menu_link}}" placeholder="Page Link" >
		</div>
	</div>

	<div class="form-group row">

		<label for="menu_status" class="col-sm-4 col-form-label col-form-label-sm">Menu Status</label>
		<div class="col-sm-8">
			<div class="form-check form-check-inline">
	         	<input class="form-check-input" type="checkbox" name=" status" id="menu_status" value="1" {{$feature_status == '1' ? 'checked' : ''}}>
	         	<label class="form-check-label" for="menu_status">Active</label>
	        </div>
		</div>
	</div>
    @php
        $response_action = route('menu-feature-table');
    @endphp

    <div class="modal-footer mt-1">
	<button type="button" class="btn btn-sm btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save changes</button>
		<button type="button" data-dismiss="modal" class="btn btn-sm btn-danger ">close</button>
		<a href="{{route('menu-feature-table')}}" class="btn btn-sm btn-info ">Exit</a>
	</div>
</form>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();
</script>
