<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<form action="{{ route('ot.store-pakage') }}" method="post" id="ot-info-create">
    @csrf

    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-success">Add New Procedure</h5>
                    </div>

                    <div class="card-body p-2">
                        <div class="form-row justify-content-center">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="id_" class="col-form-label">Procedure Name <span class="text-danger">*</span></label>
                                    <select class="form-control font_size_12 m-auto select2" name="pakage_name"
                                        id="pakage_name">
                                        <option value="0">Select Procedure</option>
                                        @if ($procedureData != '')
                                            @if (!empty($ot_items))
                                                @foreach ($ot_items as $value)
                                                    {{-- {{ dd($procedureData->procedure_no_fk , $value->item_no_pk) }} --}}
                                                    <option value="{{ $value->item_no_pk . '_' . $value->item_name }}"
                                                        {{ !empty($value->item_no_pk == $procedureData->procedure_no_fk) ? 'selected' : '' }}>
                                                        {{ $value->item_name }}</option>
                                                @endforeach
                                            @endif
                                        @else
                                            @if (!empty($ot_items))
                                                @foreach ($ot_items as $value)
                                                    {{-- {{ dd($procedureData->procedure_no_fk , $value->item_no_pk) }} --}}
                                                    <option value="{{ $value->item_no_pk . '_' . $value->item_name }}">
                                                        {{ $value->item_name }}</option>
                                                @endforeach
                                            @endif
                                        @endif


                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Pakage Details</h5>
                    </div>
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th>Item Name</th>
                                            <th>QTY</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-append-to">
                                        <tr id="0">
                                            <input type="hidden" name="hdn_id[]" id="hdn_id_0"
                                            value="">
                                            <td>
                                                <input type="text" class="form-control item_typehead" id="item_id_0"
                                                    name="item_id[]" placeholder="Enter Item Name/ Item Code">
                                                <input type="hidden" name="item_hdn_id[]" id="item_hdn_id_0">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="qty[]" id="qty_0" placeholder="Enter Qty" />
                                            </td>
                                            <td>
                                                <input type="checkbox" class="form-control form-control-sm"
                                                    name="status[]" id="status_0" value="1" checked />
                                            </td>
                                            <td>
                                                <span id="item_td_action_0" onclick="addItemRow(this)"
                                                    class="btn btn-md btn-success"> +Add </span>
                                            </td>
                                        </tr>


                                        @php
                                            $tableId = 2;
                                        @endphp
                                        @if (!empty($data))
                                            @foreach ($data as $otData)
                                                <tr id="{{ $tableId }}">
                                                    {{-- {{ dd($otData->status == 1) }} --}}
                                                    <input type="hidden" name="hdn_id[]" id="hdn_id_0"
                                                        value="{{ !empty($otData->otrm_setup_no_pk) ? $otData->otrm_setup_no_pk : '' }}">
                                                    <td>
                                                        <input type="text" class="form-control item_typehead"
                                                            id="item_id_0" name="item_id[]"
                                                            placeholder="Enter Item Name/ Item Code"
                                                            value="{{ !empty($otData->med_name) ? $otData->med_name : '' }}">
                                                        <input type="hidden" name="item_hdn_id[]" id="item_hdn_id_0"
                                                            value="{{ !empty($otData->med_item_no_fk) ? $otData->med_item_no_fk : '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="qty[]" id="qty_0" placeholder="Enter Qty"
                                                            value="{{ !empty($otData->med_qty) ? $otData->med_qty : '' }}" />
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="form-control form-control-sm"
                                                            name="status[]" id="status_0" value="1"
                                                            {{ $otData->status == 1 ? 'checked' : '' }} />
                                                    </td>
                                                    <td>
                                                        <span class='btn btn-danger btn-sm'
                                                            onclick='removeTableRowOnly(this)'> <i
                                                                class='fa fa-times'></i> </span>
                                                    </td>
                                                </tr>


                                                @php
                                                    $tableId = $tableId + 1;
                                                @endphp
                                            @endforeach
                                        @endif



                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">
                            <ul class="list-inline btn__box">
                                <li class="list-inline-item mb-0 mt-0">

                                    @php
                                        $response_action = route('ot.medicine-setup');
                                    @endphp
                                    <button class="btn btn-secondary uhl_save_btn"
                                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                        Save</button>

                                </li>

                                <li class="list-inline-item"><button type="button"
                                        class="btn btn-danger">Cancel</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
     openItemAutocompleteOnly("#item_id_0", "MED,LIQ,TAB", "", "", "", "", itemdata);
     function itemdata(item, obj) {
        $("#item_hdn_id_0").val(item.item_id)
        console.log('nazmul_' + item.item_id)
    }
</script>
