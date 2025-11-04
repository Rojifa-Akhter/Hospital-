@php

$module = (isset($module) && (!empty($module))) ? $module : [];

$module_no_pk = ($module) ? $module->module_no_pk : '';
$module_code = ($module) ? $module->module_code : '';
$module_name = ($module) ? $module->module_name : '';
$module_desc = ($module) ? $module->module_desc : '';
$module_status = ($module) ? $module->status : '';
@endphp

<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('module.store') }}" method="post" id="room-create">
        @csrf
        <input type="hidden" name="id" value="{{ $module_no_pk }}">
        <div class="form-group row">
            <label for="module_code" class="col-sm-12 col-form-label col-form-label-sm">Module Code <span class="text-danger">*</span></label>
            <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm" id="module_code" name="module_code" value="{{ $module_code }}" placeholder="Enter Module Code" required>
            </div>

            <label for="module_name" class="col-sm-12 col-form-label col-form-label-sm">Module Name <span class="text-danger">*</span></label>
            <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm" id="module_name" name="module_name" value="{{ $module_name }}" placeholder="Enter Module Name" required>
            </div>

            <label for="module_desc" class="col-sm-12 col-form-label col-form-label-sm">Module Description</label>
            <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm" id="module_desc" name="module_desc" value="{{ $module_desc }}" placeholder="Enter Module Name">
            </div>

            <label for="module_status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
			<div class="col-sm-12">
				<div class="form-check form-check-inline">
		         	<input class="form-check-input" type="checkbox" name=" module_status" id="module_status" value="1" {{ $module_status == '1' ? 'checked' : '' }}>
		         	<label class="form-check-label" for="module_status">Active</label>
		        </div>	
			</div>
        </div>
        <div class="modal-footer mt-1">
			<button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
			<button type="submit" class="btn btn-sm btn-success" onclick="btnSaveUpdate(this)">Save changes</button>
		</div>
    </form>
</div>
	

