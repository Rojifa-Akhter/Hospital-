@php
$item = (isset($item) && (!empty($item))) ? $item : [];
$item_no_pk = ($item) ? $item->item_no_pk : '';
$item_name = ($item) ? $item->item_name : '';
$item_code = ($item) ? $item->item_code : '';
$item_short_name = ($item) ? $item->item_short_name : '';
$generic_no_fk = ($item) ? $item->generic_no_fk : '';
$itemtype_no_fk = ($item) ? $item->itemtype_no_fk : '';
$serviceunit_no_fk = ($item) ? $item->serviceunit_no_fk : '';
$uom_no_fk = ($item) ? $item->uom_no_fk : '';
$item_pack_type = ($item) ? $item->item_pack_type : '';
$manufacturer_no_fk = ($item) ? $item->manufacturer_no_fk : '';
$sales_price = ($item) ? $item->sales_price : '';
$vat_percent = ($item) ? $item->vat_percent : '';
$item_status = ($item) ? $item->status : '';

@endphp
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <input type="hidden" name="id" value="{{$item_no_pk}}">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="item_name" class="col-form-label col-form-label-sm">Item Name <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="item_name" name="item_name" value="{{$item_name}}"
                            placeholder="Enter Item Name" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="item_generic_name" class="col-form-label col-form-label-sm">Generic Name <span
                                class="text-danger"></span></label>
                        <input type="text" class="form-control item_generic_name" id="item_generic_name"
                            name="item_generic_name">
                        <input type="hidden" class="form-control" id="item_generic_id" name="item_generic_id">
                    </div>
                    <div class="form-group col-md-3">

                        <label for="item_type" class="col-form-label col-form-label-sm">Item Type <span
                                class="text-danger">*</span></label>
                        <select class="form-control font_size_12 m-auto select2 " id="item_type" name="item_type" required>
                            <option value="" class="">Select Item Type</option>
                            @if(isset($item_type))
                            @foreach($item_type as $val)
                            <option value="{{$val->itemtype_no_pk}}"
                                {{ $itemtype_no_fk == $val->itemtype_no_pk ? 'selected' : '' }}>
                                {{ ucwords(strtolower($val->item_type_name)) }}</option>
                            @endforeach
                            @endif

                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="d-block">
                            <label for="item_status" class="col-form-label col-form-label-sm">Status</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name=" item_status" id="item_status"
                                value="1" {{ $item_status == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="item_status">Active</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
