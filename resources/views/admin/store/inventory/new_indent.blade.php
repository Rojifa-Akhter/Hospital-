<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">New Indent</h5>
            <small>Store / New Indent</small>
        </div>
        <div class="col-md-3">
            <div id="top-action">

                <a rel="tab" href="{{ route('inventory_indent_worklist') }}"
                    class="btn btn-outline-primary btn-md float-right"><i class="fa fa-desktop"></i>&nbsp;Indent
                    Worklist</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa fa-plus"></i> New Indent</h5>
                </div>
                <div class="card-body border-bottom-3 p-2">
                    <form action="{{ route('store_new_indent') }}" id="new_indent_form" method="post">
                        <div class="form-row d-flex justify-content-center border-bottom">
                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="store_name">Store From <span
                                        class="text-danger">*</span></label>
                                <select class="form-control select2" id="store_from" name="store_from">
                                    <option value="">Select Store</option>
                                    @if (!empty($stores))
                                        @foreach ($stores as $store)
                                           @if ($store->main_store_ind == 1)
                                                <option value="{{ $store->su_no_fk }}"
                                                @if ($store->default_ind == 1) selected @endif>
                                                {{ $store->serviceunit_name }}</option>
                                            @endif
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="store_name">Store To <span
                                        class="text-danger">*</span></label>
                                <select class="form-control select2" id="store_to" name="store_to">
                                    <option value="">Select Store</option>
                                    @if (!empty($stores))
                                        @foreach ($stores as $store)
                                            @if ($store->sub_store_ind == 1)
                                                    <option value="{{ $store->su_no_fk }}"
                                                    @if ($store->default_ind == 1) selected @endif>
                                                    {{ $store->serviceunit_name }}</option>
                                            @endif
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="date">Date <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm m-0 date_picker" id="date"
                                    name="date" value="" placeholder="yyyy-mm-dd">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="date">Patient Name</label>
                                <input type="text" class="form-control form-control-sm m-0" id="patient_id"
                                    name="patient_name" value="" placeholder="Patient Name">
                                <input type="hidden" id="hdn_patient_id" name="hdn_patient_id">
                            </div>
                            {{-- <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="store_name">Reason</label>
                                <select class="form-control select2" id="reason" name="reason">
                                    <option value="">Select Reason</option>
                                    @if (isset($return_reason))
                                        @foreach ($return_reason as $key=>$val)
                                                <option value="{{ $key }}">{{ $val }}</option>

                                        @endforeach
                                    @endif

                                </select>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row d-flex justify-content-center">
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="pvms_no">Item Code</label>
                                        <input type="text" class="form-control form-control-sm m-0" id="pvms_no"
                                            name="pvms_no" value="" placeholder="Item Code">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="item_name">Item
                                            Name</label>
                                        <input type="hidden" name="item_id_hidden" id="item_id_hidden">
                                        <input type="text" class="form-control form-control-sm m-0" id="item_name"
                                            name="item_name" value="" placeholder="Item Name">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="item_uom">Item UoM</label>
                                        <input type="hidden" name="item_uom_hidden" id="item_uom_hidden">
                                        <input type="text" class="form-control form-control-sm m-0" id="item_uom"
                                            name="item_uom" value="" placeholder="Item UoM">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="item_quantity">Item
                                            Quantity</label>
                                        <input type="text"
                                            class="form-control form-control-sm m-0 text-right number_only"
                                            id="item_quantity" name="item_quantity" value="0"
                                            placeholder="Item Quantity">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="add_item_btn" class="btn btn-success btn-md mt-4"><i
                                                class="fa fa-plus"></i> Add Item</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table data-table table-striped table-bordered table-hover">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center" width="15%">SL</th>
                                            <th class="text-center" width="15%">Item Code</th>
                                            <th class="text-center" width="15%">Item Name</th>
                                            <th class="text-center" width="15%">Item UoM</th>
                                            <th class="text-center" width="15%">Indent Quantity</th>
                                            <th class="text-center" width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="items_to_receive"></tbody>
                                </table>
                            </div>
                        </div>
                        {{-- <div class="row">
                            @php
                                $response_action = route('pharmacy_indent_worklist');
                            @endphp
                            <div class="col-12 text-right">
                                <span onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"  class="btn btn-success btn-md"><i class="fa fa-save"></i> Save</span>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="custom-box">
                                    <div class="custom-box-body m-0 text-right">

                                        @php
                                            $response_action = route('pharmacy_indent_worklist');
                                        @endphp

                                        <span
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                            class="btn btn-success btn-md"><i class="fa fa-save"></i> Save</span>

                                        <button type="reset" class="btn btn-info btn-md"
                                            title="Click here to Clear form data">Clear</button>
                                        <a href="#" class="btn btn-danger btn-md" rel="tab"
                                            title="Click here to go back to Dashboard">Exit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $('.date_picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    openPatientAutocomplete('#patient_id', 'patient_name');
    inventory_autocomplete_iteminfo_by_item_code('#pvms_no', 'pvms_no', function(item, obj) {
        console.log(item.item_code);
        //console.log(item.uom_name+'tajul');
        $('#item_id_hidden').val(item.item_id)
        $('#item_uom_hidden').val(item.uom_no_fk)
        $('#item_uom').val(item.uom_name)
        $('#pvms_no').val(item.item_code);
        $('#item_name').val(item.item_name)
        obj.stopImmediatePropagation();

    });
    inventory_autocomplete_iteminfo_by_item_name('#item_name', 'item_name', function(item, obj) {
        $('#item_id_hidden').val(item.item_id)
        $('#item_uom_hidden').val(item.uom_no_fk)
        $('#item_uom').val(item.uom_name)
        $('#pvms_no').val(item.item_code)
        obj.stopImmediatePropagation();
    });

    $(document).on('click', '#add_item_btn', function(e) {
        e.preventDefault()
        var pvms_no = $('#pvms_no').val()
        var item_name = $('#item_name').val()
        var item_id = $('#item_id_hidden').val()
        var item_uom_name = $('#item_uom').val()
        var item_uom_no = $('#item_uom_hidden').val()
        var item_quantity = $('#item_quantity').val()

        if (item_name == '' || item_id == '') {
            alert('Item Name cannot be blank')
            e.stopImmediatePropagation()
            return false
        }
        var same_item = false
        $('input[class=same-item-id]').each(function(index, elem) {
            if ($(elem).val() == item_id) {
                same_item = true
                return false
            }
        })
        if (same_item == true) {
            alert('You have already taken this item.')
            $('#pvms_no').val('')
            $('#item_name').val('')
            $('#item_id_hidden').val('')
            $('#item_uom').val('')
            $('#item_uom_hidden').val('')
            $('#item_quantity').val(0)
            $('#item_price').val(0)
            e.stopImmediatePropagation();
            return false
        }
        var row = '<tr>' +
            '<td class="sl-td">0</td>' +
            '<td> <input type="hidden" name="pvms_nos[]" value="' + pvms_no + '">' + pvms_no + '</td>' +
            '<td> <input type="hidden" class=same-item-id name="item_ids[]" value="' + item_id + '">' +
            item_name + '</td>' +
            '<td> <input type="hidden" name="item_uoms[]" value="' + item_uom_no + '">' + item_uom_name +
            '</td>' +
            '<td class="text-right"> <input class="text-right number_only" type="text" name="item_quantities[]" value="' +
            item_quantity + '"></td>' +
            '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
            '</tr>'

        $('#items_to_receive').append(row)

        $('#pvms_no').val('')
        $('#item_name').val('')
        $('#item_id_hidden').val('')
        $('#item_uom').val('')
        $('#item_uom_hidden').val('')
        $('#item_quantity').val(0)
        $('#item_price').val(0)

        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
        e.stopImmediatePropagation();
    })

    $(document).on('click', '.remove-item-btn', function() {
        $(this).closest('tr').remove()
        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
    })
</script>
