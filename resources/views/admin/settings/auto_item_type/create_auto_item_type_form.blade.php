@php

$item_type = isset($data) && !empty($data) ? $data : [];

$autoitemlst_code = $item_type ? $item_type->autoitemlst_code : '';
$item_no_fk = $item_type ? $item_type->item_no_fk : '';
$auto_item_no_fk = $item_type ? $item_type->auto_item_no_fk : '';
$free_ind = $item_type ? $item_type->free_ind : '';
$pkg_item_ind = $item_type ? $item_type->pkg_item_ind : '';

$item_uom = $item_type ? $item_type->item_uom : '';
$item_qty = $item_type ? $item_type->item_qty : '';
$discount_applicable_ind = $item_type ? $item_type->discount_applicable_ind : '';
$status = $item_type ? $item_type->status : '';
$autoitemlst_no_pk = $item_type ? $item_type->autoitemlst_no_pk : '';

@endphp


<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">


<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form action="{{ route('store-auto-item-type') }}" method="post" id="auto_item_type_form">
            @csrf
            <input type="hidden" name="id" value="{{ $autoitemlst_no_pk }}">
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="auto_item_type_code" class="col-form-label col-form-label-sm">Itme Type Code<span
                            class="text-danger">*</span></label>

                    <input type="text" class="form-control form-control-sm" id="auto_item_type_code" value="{{ $autoitemlst_code }}"
                        name="auto_item_type_code" value="" placeholder="Enter Itme Type Code" required>
                </div>
            </div>



            {{-- <div class="form-group row">
                <div class="col-md-12">
                    <label for="parent_item_type" class="">Parent Item Type <span
                            class="text-danger">*</span></label>
                    <div class="">
                        <select class="form-control font_size_12 m-auto select2" id="parent_item_type"
                            name="parent_item_type" required>
                            <option selected="selected" value="">Select Parent Item Type Name</option>
                            @foreach ($item_type as $type)
                                <option value="{{ $type->itemtype_no_pk }}">
                                    {{ $type->item_name }}</strong>
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div> --}}


            <div class="form-group row">

                <div class="col-md-12">
                    <label for="item_name" class="col-form-label col-form-label-sm">Parent  Item Name <span
                            class="text-danger">*</span></label>
                    <div class="" id="item_name">
                        @include('admin.settings.auto_item_type.item_list')


                    </div>
                </div>
            </div>


            <div class="form-group row">

                <div class="col-md-12">
                    <label for="item_name" class="col-form-label col-form-label-sm">Item Name <span
                            class="text-danger">*</span></label>
                    <div class="" id="item_name">
                        {{-- @include('admin.settings.auto_item_type.item_list') --}}

                        <select class="form-control font_size_12 m-auto select2" id="item_name_select" name="item_name" required>
                            <option selected="selected" value="">Select Item Name</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->item_no_pk }}"  {{ $auto_item_no_fk == $item->item_no_pk ? 'selected' : '' }}>{{ $item->item_name }} </option>
                            @endforeach
                        </select>



                    </div>
                </div>
            </div>


            {{-- <div class="form-group row">
                <div class="col-md-12">
                    <label for="item_name" class="col-form-label col-form-label-sm">Item Name<span
                            class="text-danger">*</span></label>

                    <input type="text" class="form-control form-control-sm" id="item_name" value=""
                        name="item_name" value="" placeholder="Enter Item Name" required>
                </div>
            </div> --}}

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="uom" class="col-form-label col-form-label-sm">UOM</label>

                    <input type="text" class="form-control form-control-sm number_only" id="uom" value="{{ $item_uom }}"
                        name="uom" value="" placeholder="Enter UOM" >
                </div>
                <div class="col-md-6">
                    <label for="item_qty" class="col-form-label col-form-label-sm">Item Quantity<span
                            class="text-danger">*</span></label>

                    <input type="text" class="form-control form-control-sm number_only" id="item_qty" value="{{ $item_qty }}"
                        name="item_qty" value="" placeholder="Enter Item Quantity" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="discount_available"
                            id="discount_available" value="1" {{ $discount_applicable_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="discount_available">Discount Available</label>
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="pakage_item" id="pakage_item" value="1" {{ $pkg_item_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="pakage_item">Pakage Item</label>
                    </div>
                </div>


                <div class="col-md-4">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="free_item" id="free_item" value="1" {{ $free_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="free_item">Free Item</label>
                    </div>
                </div>
            </div>







            <div class="form-group row">

                <div class="col-md-12">
                    <label for="status" class="">Status</label>
                    <div class="">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
                                {{ $status == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </div>
                </div>
            </div>



            @php
                $response_action = route('auto-item-type');
            @endphp

            <div class="text-left">
                <button type="submit" class="btn btn-md btn-success"
                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                    Save
                </button>
                <button type="reset" class="btn btn-md btn-info " data-dismiss="modal">Clear</button>
                <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button>
            </div>
        </form>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
    $('.select2').select2({});
    $(document).on('change', '#parent_item_type', function(e) {
        var item_type = $('#parent_item_type').val();
        $.ajax({
            url: "{{ route('auto-item-list-for-item-type') }}",
            type: 'POST',
            data: {
                item_type: item_type
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $('#item_name').html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    })
</script>
