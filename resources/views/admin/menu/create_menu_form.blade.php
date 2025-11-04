@php

$parent_menu = (isset($parent_menu) && (!empty($parent_menu))) ? $parent_menu : [];
$menu = (isset($data) && (!empty($data))) ? $data : [];
// print_r($parent_menu);
// print_r($menu->menu_no_pk);

$id = ($menu) ? $menu->menu_no_pk : '';
$menu_code = ($menu) ? $menu->menu_code : '';
$parent_menu_no_fk = ($menu) ? $menu->parent_menu_no_fk : '';
$menu_name = ($menu) ? $menu->menu_name : '';
$menu_name_nls = ($menu) ? $menu->menu_name_nls : '';
$sl_no = ($menu) ? $menu->sl_no : '';
$menu_link = ($menu) ? $menu->menu_link : '';
$menu_icon = ($menu) ? $menu->menu_icon : '';
$menu_status = ($menu) ? $menu->status : '';

@endphp

<form method="post" id="frm-menu-store" action="{{ route('menu.store') }}">
	@csrf
	<input type="hidden" name="id" value="{{$id}}" value="">
	<div class="form-group row">
		<label for="menu_id" class="col-sm-2 col-form-label col-form-label-sm">Menu UID <span class="text-danger">*</span></label>
		<div class="col-sm-10">
			<input type="text" class="form-control form-control-sm" id="menu_id" name="menu_id" value="{{$menu_code}}" placeholder="Enter Menu Id" required>
		</div>

		<label for="parent_menu" class="col-sm-2 col-form-label col-form-label-sm">Parent Menu</label>
		<div class="col-sm-10">
			<select class="form-control font_size_12 m-auto" id="parent_menu" name="parent_menu" required>
				<option value="0">Select Parent Menu</option>
				@if(isset($parent_menu) && $parent_menu->count() > 0 )
				@foreach($parent_menu as $key => $value)
				<option value="{{$value->menu_no_pk}}" {{$parent_menu_no_fk == $value->menu_no_pk ? 'selected' : ''}}>{{$value->menu_name}}</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>

	<div class="form-group row">
		<label for="menu_name" class="col-sm-2 col-form-label col-form-label-sm">Menu Name <span class="text-danger">*</span></label>
		<div class="col-sm-10">
			<input type="text" class="form-control form-control-sm" id="menu_name" name="menu_name" value="{{$menu_name}}" placeholder="Enter lookup Name" required>
		</div>

		<label for="serial_number" class="col-sm-2 col-form-label col-form-label-sm">Serial Number</label>
		<div class="col-sm-10">
			<input type="text" class="form-control form-control-sm" id="serial_number" name="serial_number" value="{{$sl_no}}" placeholder="Serial Number">
		</div>
	</div>

	<div class="form-group row">
		<label for="menu_name_nis" class="col-sm-2 col-form-label col-form-label-sm">Menu Name nIs</label>
		<div class="col-sm-10">
			<input type="text" class="form-control form-control-sm" id="menu_name_nis" name="menu_name_nis" value="{{$menu_name_nls}}" placeholder="Menu Name nIs">
		</div>



		<label for="page_link" class="col-sm-2 col-form-label col-form-label-sm">Page Link <span class="text-danger">*</span></label>
		<div class="col-sm-10">
			<input type="text" class="form-control form-control-sm" id="page_link" name="page_link" value="{{$menu_link}}" placeholder="Page Link" required>
		</div>
	</div>

	<div class="form-group row">
		<label for="menu_icon" class="col-sm-2 col-form-label col-form-label-sm">Menu Icon</label>
		<div class="col-sm-10">
			<input type="text" class="form-control form-control-sm" id="menu_icon" name="menu_icon" value="{{$menu_icon}}" placeholder="Menu icon class">
		</div>

		<label for="menu_status" class="col-sm-2 col-form-label col-form-label-sm">Menu Status</label>
		<div class="col-sm-10">
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="checkbox" name=" menu_status" id="menu_status" value="1" {{$menu_status == 1 ? 'checked' : ''}}>
				<label class="form-check-label" for="menu_status">Active</label>
			</div>
		</div>
	</div>


	@php
	$doctor_id = "";
	$response_url = route('menu.index');
	@endphp

	<div class="modal-footer mt-1">
		<button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url }}')">Save changes</button>
		<button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-md btn-info " data-dismiss="modal">Exit</button>

	</div>
</form>