<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<form action="{{ route('inventory.store_stock_adjustment') }}" method="post" id="return_item_by_challan_form">
    @csrf
    <div class="form-group form-row">
        <div class="col-12 table-responsive">
            <table class="table data-table table-striped table-bordered table-hover mb-0">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-center">SL</th>
                        <th class="text-center">Challan No</th>
                        <th class="text-center">Item Name</th>
                        <th class="text-center">Received Item
                        </th>
                        <th class="text-center">Return Item</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($item_list))
                        @foreach ($item_list as $item)
                            <input type="hidden" name="challan_no" value="{{ $item->challan_no }}">
                            <input type="hidden" name="date" value="{{ $item->challan_date }}">
                            <input type="hidden" name="store_id" value="{{ $item->store_su_no_fk }}">
                            <input type="hidden" name="in_purchaseorder_no_fk" value="0">
                            <input type="hidden" name="supplier_id" value="0">
                            <input type="hidden" name="stock_type" value="RCVRTN">
                            <input type="hidden" name="item_ids[]" value="{{ $item->item_no_fk }}">

                            <input type="hidden" name="item_prices[]" value="{{ $item->purchase_price }}">

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->challan_no }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->received_quantity }}</td>
                                <td><input type="text" name="item_quantities[]" onkeyup="checkquantity(this)"
                                        onkeydown="checkquantity(this)" data-itemID="{{ $item->received_quantity }}"
                                        value="" style="width: 50px;">
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer p-0 pt-2">
        @php
            $response_action = route('inventory.item_received_worklist');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save
        </button>

        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('inventory.item_received_worklist') }}" type="reset" class="btn btn-danger btn-md"
            title="Click here to Clear form data">Exit</a>

    </div>
</form>



<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    // getDropdownListByCondition("#","","");
    $('.select2').select2({});

    function checkquantity(element) {
        var item_qty = parseInt($(element).attr('data-itemID'));
        var curr_qty = parseInt($(element).val());
        if (curr_qty > item_qty) {
            alert("Invalid Quantity");
            $(element).val('');
        }
        console.log(item_qty, curr_qty);
    }
</script>
