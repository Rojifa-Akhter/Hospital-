<div class="border-bottom"><input type="checkbox" id="all_check" > 
	<label for="all_check"><strong> All Select</strong></label>
</div>
@foreach($menu_feature as $module_id => $module_data)
@php $menu = 0 @endphp
<div class="menu-item mt-1 mb-1 border-bottom">
	@foreach($module_data as $feature_id => $feature)
		@php 
			$menu_feature = explode('_', $feature);
			$menu ++; 
			$is_checked = isset($features[$feature_id]) ? 'checked = "z"': '';
		@endphp
	@if($menu == 1)
	<div><input type="checkbox" class="modul_checkbox" name="modul_checkbox" id="modul_name_check_{{ $menu_feature[0] }}" > <label class="form-check-label" for="modul_name_check_{{ $menu_feature[0] }}"> <strong> {{ $menu_feature[0] }} </strong></label></div>
	@endif

	<input type="checkbox" class="menu_name" name="menu_name[]" id="menu_name_{{ $feature_id }}" {{ $is_checked }} value="{{ $feature_id }}_{{ $module_id }}  "> <label class="form-check-label" for="menu_name_{{ $feature_id }}"> {{ $menu_feature[1] }}</label> <br />

	@endforeach
</div>
@endforeach
