@php
    
    $item_type = isset($item_type) && !empty($item_type) ? $item_type : [];
    $itemtype_no_pk = $item_type ? $item_type->itemtype_no_pk : '';
    $item_type_name = $item_type ? $item_type->item_type_name : '';
    $itemtype_code = $item_type ? $item_type->itemtype_code : '';
    $par_itemtype_no_fk = $item_type ? $item_type->par_itemtype_no_fk : '';
    
    $sl_no = $item_type ? $item_type->sl_no : '';
    $default_discount = $item_type ? $item_type->default_discount : '';
    $acc_ledger_no_fk = $item_type ? $item_type->acc_ledger_no_fk : '';
    $acc_par_itemtype_no_fk = $item_type ? $item_type->acc_par_itemtype_no_fk : '';
    $type_auto_con_flag = $item_type ? $item_type->type_auto_con_flag : '';
    $status = $item_type ? $item_type->status : '';
    $major_group_ind = $item_type ? $item_type->major_group_ind : '';
    $minor_group_ind = $item_type ? $item_type->minor_group_ind : '';
    $ipd_discount_head_ind = $item_type ? $item_type->ipd_discount_head_ind : '';
    $ipd_bill_summary_head_ind = $item_type ? $item_type->ipd_bill_summary_head_ind : '';
    $referral_payment_head_ind = $item_type ? $item_type->referral_payment_head_ind : '';
    $inventory_ind = $item_type ? $item_type->inventory_head_ind : '';
    $asset_group_ind = $item_type ? $item_type->asset_group_ind : '';
    $asset_su_no_fk = $item_type ? $item_type->asset_su_no_fk : '';
    
    $asset_depreciation_pct = $item_type ? $item_type->asset_depreciation_pct : '';
    $asset_depreciation_life_year = $item_type ? $item_type->asset_depreciation_life_year : '';
    $depreciation_residual_val_pct = $item_type ? $item_type->depreciation_residual_val_pct : '';
    
@endphp

<link rel="stylesheet" href="{{asset('node_modules/select2/dist/css/select2.min.css')}}">
<form method="post" id="frm-item-store" action="{{ route('item-type-store') }}">
    @csrf
    <input type="hidden" name="id" value="{{ $itemtype_no_pk }}">
    <div class="form-group row">
        <label for="item_type_code" class="col-sm-12 col-form-label col-form-label-sm">Item Code <span
                class="text-danger">*</span></label>
        <div class="col-sm-12">
            <div class="input-group">
                <input type="text" class="form-control form-control-sm" id="item_type_code" name="item_type_code"
                    value="{{ $itemtype_code }}" placeholder="Enter Item Type Code" required>

            </div>
        </div>
        <label for="item_type_name" class="col-sm-12 col-form-label col-form-label-sm">Item Type <span
                class="text-danger">*</span></label>
        <div class="col-sm-12">
            <div class="input-group">
                <input type="text" class="form-control form-control-sm" id="item_type_name" name="item_type_name"
                    value="{{ $item_type_name }}" placeholder="Enter Item Type Name" required>

            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="parent_type" class="col-sm-12 col-form-label col-form-label-sm">Major Group</label>
        <div class="col-sm-12">
            <select class="form-control font_size_12 m-auto select2" id="parent_type" name="parent_type" required>
                <option value="0">Select Major Group</option>
                @if (isset($item_type_parent))
                    @foreach ($item_type_parent as $key => $val)
                        @if ($itemtype_no_pk != $val->itemtype_no_pk)
                            <option value="{{ $val->itemtype_no_pk }}"
                                {{ $par_itemtype_no_fk == $val->itemtype_no_pk ? 'selected' : '' }}>
                                {{ $val->item_type_name }}</option>
                        @endif
                    @endforeach
                @endif

            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="item_serial_number" class="col-sm-12 col-form-label col-form-label-sm">Serial Number <span
                class="text-danger">*</span></label>
        <div class="col-sm-12">
            <input type="number" class="form-control form-control-sm required" id="item_serial_number"
                name="item_serial_number" value="{{ $sl_no }}" placeholder="Serial Number" required
                min="1" max="99">
        </div>
    </div>

    <div class="form-group row">
        <label for="default_discount" class="col-sm-12 col-form-label col-form-label-sm">Default Discount</label>
        <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm number_only" id="default_discount"
                name="default_discount" value="{{ $default_discount }}" placeholder="Enter Default Discount">
        </div>
    </div>

    <div class="form-group row">
        <label for="asset_sub_store" class="col-sm-12 col-form-label col-form-label-sm">Asset Sub Store</label>
        <div class="col-sm-12">
            <select class="form-control font_size_12 m-auto select2" id="asset_sub_store" name="asset_sub_store" required>
                <option value="0">Select</option>
                @if (isset($asset_sub_store))
                    @foreach ($asset_sub_store as $key => $val)
                        <option value="{{ $val->serviceunit_no_pk }}"
                            {{ $asset_su_no_fk == $val->serviceunit_no_pk ? 'selected' : '' }}>
                            {{ $val->serviceunit_name }}</option>
                    @endforeach
                @endif

            </select>
        </div>
    </div>
   

    <div class="form-group row">
        <label for="asset_depreciation_pct" class="col-sm-12 col-form-label col-form-label-sm">Asset Depreciation
            %</label>
        <div class="col-sm-12">
            <input type="number" class="form-control form-control-sm number_only" id="asset_depreciation_pct"
                name="asset_depreciation_pct" value="{{ $asset_depreciation_pct }}"
                placeholder="Enter Asset Depreciation Percentage">
        </div>
    </div>

    <div class="form-group row">
        <label for="asset_depreciation_life_year" class="col-sm-12 col-form-label col-form-label-sm">Asset Depreciation
            Life Year</label>
        <div class="col-sm-12">
            <input type="number" class="form-control form-control-sm number_only" id="asset_depreciation_life_year"
                name="asset_depreciation_life_year" value="{{ $asset_depreciation_life_year }}"
                placeholder="Asset Depreciation Life Year">
        </div>
    </div>

    <div class="form-group row">
        <label for="depreciation_residual_val_pct" class="col-sm-12 col-form-label col-form-label-sm">Depreciation
            Residual
            Value %</label>
        <div class="col-sm-12">
            <input type="number" class="form-control form-control-sm number_only" id="depreciation_residual_val_pct"
                name="depreciation_residual_val_pct" value="{{ $depreciation_residual_val_pct }}"
                placeholder="Depreciation Residual Value Percentage">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-12 col-sm-6 col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="account_ledger" value="1"
                    id="account_ledger" {{ $acc_ledger_no_fk == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="account_ledger">Account Ledger</label>
            </div>
        </div>

        <div class="col-sm-12 col-sm-6 col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="auto_posting" value="1"
                    id="auto_posting" {{ $acc_par_itemtype_no_fk == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="auto_posting">Account Auto-Posting</label>
            </div>
        </div>

        <div class="col-sm-12 col-sm-6 col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="parent_ledger" value="1"
                    id="parent_ledger" {{ $type_auto_con_flag == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="parent_ledger">Parent Ledger</label>
            </div>
        </div>

        <div class="col-sm-12 col-sm-6 col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="major_group_ind" id="major_group_ind"
                    value="1" {{ $major_group_ind == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="major_group_ind">Major Group Ind</label>
            </div>
        </div>
        <div class="col-sm-12 col-sm-6 col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="minor_group_ind" id="minor_group_ind"
                    value="1" {{ $minor_group_ind == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="minor_group_ind">Minor Group Ind</label>
            </div>
        </div>

        <div class="col-sm-12 col-sm-6 col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="ipd_discount_head_ind"
                    id="ipd_discount_head_ind" value="1" {{ $ipd_discount_head_ind == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="ipd_discount_head_ind">IPD Bill Summary Discount Ind</label>
            </div>
        </div>


        <div class="col-sm-12 col-sm-6 col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="ipd_bill_summary_head_ind"
                    id="ipd_bill_summary_head_ind" value="1"
                    {{ $ipd_bill_summary_head_ind == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="ipd_bill_summary_head_ind">IPD Bill Summary Head Ind</label>
            </div>
        </div>


        <div class="col-sm-12 col-sm-6 col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="referral_payment_head_ind"
                    id="referral_payment_head_ind" value="1"
                    {{ $referral_payment_head_ind == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="referral_payment_head_ind">Refferal Payment Head Ind</label>
            </div>
        </div>

        <div class="col-sm-12 col-sm-6 col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="item_status" id="item_status" value="1"
                    {{ $status == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="item_status">Item Status</label>
            </div>
        </div>

        <div class="col-sm-12 col-sm-6 col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="asset_su_no_fk" id="asset_su_no_fk"
                    value="1" {{ $asset_su_no_fk == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="asset_su_no_fk">Inventory Head Ind</label>
            </div>
        </div>
        <div class="col-sm-12 col-sm-6 col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="asset_group_ind" id="asset_group_ind"
                    value="1" {{ $asset_group_ind == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="asset_group_ind">Asset Group Ind</label>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        @php
            $doctor_id = '';
            $response_url = route('item-type');
        @endphp
        <div class="modal-footer mt-1">
            <button type="submit" class="btn btn-md btn-success"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url }}')">Save
                changes</button>
            <button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-md btn-info " data-dismiss="modal">Exit</button>

        </div>
    </div>
</form>
<script src="{{asset('node_modules/select2/dist/js/select2.min.js')}}"></script>

<script>
       $('.select2').select2();
</script>