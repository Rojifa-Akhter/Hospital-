@php

$itemType = (isset($itemTypeData) && (!empty($itemTypeData))) ? $itemTypeData : [];

$workflow_no_pk = ($itemType) ? $itemType->workflow_no_pk : '';
$item_type_code = ($itemType) ? $itemType->workflow_code : '';
$item_type_name = ($itemType) ? $itemType->workflow_name : '';
$item_type_desc = ($itemType) ? $itemType->workflow_desc : '';
$item_type_status = ($itemType) ? $itemType->status : '';
@endphp

<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('item.store-billing-item-type') }}" method="post" id="billing-item-type-id">
        @csrf
        <input type="hidden" name="id" value="{{ $workflow_no_pk }}">
        <div class="form-group row">
            <label for="item_type_code" class="col-sm-12 col-form-label col-form-label-sm">Item Type Code <span class="text-danger">*</span></label>
            <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm" id="item_type_code" name="item_type_code" value="{{ $item_type_code }}" placeholder="Enter Item Type Code" required>
            </div>

            <label for="item_type_name" class="col-sm-12 col-form-label col-form-label-sm">Item Type Name <span class="text-danger">*</span></label>
            <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm" id="item_type_name" name="item_type_name" value="{{ $item_type_name }}" placeholder="Enter Item Type Name" required>
            </div>

            <label for="item_type_desc" class="col-sm-12 col-form-label col-form-label-sm">Item Type Description</label>
            <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm" id="item_type_desc" name="item_type_desc" value="{{ $item_type_desc }}" placeholder="Enter Item Type Description">
            </div>

            <label for="item_type_status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
			<div class="col-sm-12">
				<div class="form-check form-check-inline">
		         	<input class="form-check-input" type="checkbox" name=" item_type_status" id="item_type_status" value="1" {{ $item_type_status == '1' ? 'checked' : '' }}>
		         	<label class="form-check-label" for="item_type_status">Active</label>
		        </div>
			</div>
        </div>
        <div class="modal-footer mt-1">
			<button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
			<button type="submit" class="btn btn-sm btn-success" onclick="btnSaveUpdate(this)">Save changes</button>
		</div>
    </form>
</div>


