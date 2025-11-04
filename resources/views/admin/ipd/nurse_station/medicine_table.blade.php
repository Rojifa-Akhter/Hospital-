<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<div class="card border-0 shadow-xs mt-0">
    {{-- <div class="card-header"><h5>Medicine</h5>
        <label class="col-form-label col-form-label-sm" for="store_name"> To Store <span
            class="text-danger">*</span></label>
    <select class="select2" id="store_from" name="store_from" onchange="getStore(this)" required>
        <option value="">Select Store</option>
        @if (!empty($stores))
            @foreach ($stores as $store)
                @if ($store->med_store_ind == 1)
                    <option value="{{ $store->su_no_fk }}"
                        @if ($store->default_ind == 1) selected @endif>
                        {{ $store->serviceunit_name }}</option>
                @elseif ($store->hospital_store_ind == 1)
                    <option value="{{ $store->su_no_fk }}"
                    @if ($store->default_ind == 1) selected @endif>
                    {{ $store->serviceunit_name }}</option>
                @endif
            @endforeach
        @endif
    </select> --}}
    {{-- </div> --}}
    {{-- @dd($stores) --}}
    <table width="50%">
        <tr>
            <td style="width:10px">
                <h5>Medicine/Surgical</h5>
            </td>
            <td style="width:10px">
                <h5> To Store : </h5>
            </td>
            <td style="width:10px">

                <select class="select2" id="store_from" name="store_from" onchange="getStore(this)" required>
                    <option value="">Select Store</option>

                    @if (!empty($stores) && isset($stores))

                        @foreach ($stores as $store)
                            @if ($store->med_store_ind == 1)
                                <option value="{{ $store->su_no_fk }}"
                                    @if ($store->default_ind == 1) selected @endif>
                                    {{ $store->serviceunit_name }}</option>
                            @elseif ($store->hospital_store_ind == 1)
                                <option value="{{ $store->su_no_fk }}"
                                    @if ($store->default_ind == 1) selected @endif>
                                    {{ $store->serviceunit_name }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </td>
        </tr>
    </table>



    <div class="card-body card-collapse-body mt-0">
        <form action="{{ route('nurse_station_indent') }}" id="indentReq_store" method="post">
            @csrf
            <table class="table border table-striped table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">SL</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Time</th>
                        <th class="text-center">Medicine/Surgical</th>
                        <th class="text-center">Dose</th>
                        <th class="text-center">Duration</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Instruction</th>
                        <th class="text-center">Doctor Name</th>
                        <th class="text-center">Return Qty.</th>
                        <th class="text-center">Current Qty.</th>
                        <th class="text-center">Indent Qty.</th>
                        <th class="text-center"> <input
                            type="checkbox" id="selectAllMedicine" /> Indent</th>

                        <th class="text-center">Action</th>
                        <th class="text-center">Entry By</th>
                        <th class="text-center">Entry At</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($ipd_med_list) --}}
                    @if (!empty($ipd_med_list))
                        <input type="hidden" name="patient_id" value="{{ reset($ipd_med_list)->patient_no_fk }}">
                        <input type="hidden" name="admission_id" value="{{ reset($ipd_med_list)->admission_pk_no }}">
                        <input type="hidden" name="pres_med_id" value="{{ reset($ipd_med_list)->prescription_med_no_pk }}">
                        <input type="hidden" name="phr_department_id" id="phr_department_id" value="">
                        @foreach ($ipd_med_list as $ipd_med_item)
                            {{-- {{dd($ipd_med_item)}} --}}
                            <tr>
                                <td class="center">{{ $loop->iteration }}</td>
                                <td class="text-left">
                                    {{ !empty($ipd_med_item->au_entry_at) ? date('d/m/Y', strtotime($ipd_med_item->au_entry_at)) : '' }}
                                </td>
                                <td class="text-left">
                                    {{ !empty($ipd_med_item->au_entry_at) ? date('h:i:s a', strtotime($ipd_med_item->au_entry_at)) : '' }}
                                </td>
                                <td class="text-left">
                                    {{ !empty($ipd_med_item->item_name) ? $ipd_med_item->item_name : '' }} <strong>{{ !empty($ipd_med_item->pack_type) ? '['.$ipd_med_item->pack_type.']' : '' }}</strong></td>
                                <td class="text-right">{{ !empty($ipd_med_item->dosage) ? $ipd_med_item->dosage : '' }}
                                </td>
                                <td class="text-right">
                                    {{ !empty($ipd_med_item->duration) ? $ipd_med_item->duration : '' }}&nbsp;<small>{{ !empty($ipd_med_item->duration_mu) ? $ipd_med_item->duration_mu : '' }}</small>
                                </td>
                                <td class="text-right">
                                    {{ !empty($ipd_med_item->item_qty) ? $ipd_med_item->item_qty : '' }}&nbsp;<small>{{ !empty($ipd_med_item->uom_txt) ? $ipd_med_item->uom_txt : '' }}</small>
                                </td>
                                <td class="text-left">
                                    {{ !empty($ipd_med_item->instruction_take) ? $ipd_med_item->instruction_take : '' }}
                                </td>
                                <td class="text-left">
                                    {{ !empty($ipd_med_item->ipd_instructed_doc_name) ? $ipd_med_item->ipd_instructed_doc_name : '' }}&nbsp;<small>({{ !empty($ipd_med_item->ipd_instruct_media_name) ? $ipd_med_item->ipd_instruct_media_name : '' }})</small>
                                </td>
                                <td class="text-center" >
                                    <span class="qty_val">{{ !empty($ipd_med_item->ret_quantity) ? $ipd_med_item->ret_quantity : 0 }}</span> &nbsp;<small>{{ !empty($ipd_med_item->uom_txt) ? $ipd_med_item->uom_txt : '' }}</small>
                                </td>
                                <td class="text-center">
                                    {{ !empty($ipd_med_item->current_qty) ? $ipd_med_item->current_qty : 0 }}&nbsp;<small>{{ !empty($ipd_med_item->uom_txt) ? $ipd_med_item->uom_txt : '' }}</small>
                                </td>
                                {{-- <td class="text-center">{{ !empty($ipd_med_item->au_name)? ucfirst($ipd_med_item->au_name): 0 }}</td>
                        <td class="text-center">{{ !empty($ipd_med_item->au_date)? date('h:i:s a', strtotime($ipd_med_item->au_date)): 0 }}</td> --}}
                                <td>
                                    <input type="hidden" name="item_id_{{ $ipd_med_item->prescription_med_no_pk }}"
                                        value="{{ $ipd_med_item->item_no_fk }}">
                                    <input type="text" name="indent_qty_{{ $ipd_med_item->prescription_med_no_pk }}"
                                        id="indent_qty" value="" placeholder="Enter Indent Qty"
                                        class="form-control number_only text-right"   onkeyup="indentItemCount(this)"    >
                                    <input type="hidden" name="uom_{{ $ipd_med_item->prescription_med_no_pk }}"
                                        value="{{ $ipd_med_item->uom_no_fk }}">
                                    <input type="hidden" name="pres_med_{{ $ipd_med_item->prescription_med_no_pk }}"
                                        value="{{ $ipd_med_item->prescription_med_no_pk }}">

                                </td>
                                <td class="text-center"
                                    style="{{ $ipd_med_item->req_quantity > 0 ? 'background-color:rgb(177, 245, 177)' : '' }};">

                                    <input type="checkbox" name="indent_req[]" id="indent_req"
                                        value="{{ $ipd_med_item->prescription_med_no_pk }}">
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn"
                                        id="remove-item-btn"
                                        data-value-med="{{ $ipd_med_item->prescription_med_no_pk }}"
                                        data-value-admission="{{ $ipd_med_item->admission_pk_no }}"
                                        data-value-patient="{{ $ipd_med_item->patient_no_fk }}" title="Remove"><i
                                            class="fa fa-times-circle">discontinue</i></a>

                                    <span class="open-modal btnView btn btn-sm btn-info ml-1"
                                        data-action="{{ route('ipd.medicine-dose-edit', $ipd_med_item->prescription_med_no_pk) }}"
                                        data-modal="common-modal-md" data-title="Dose Change" title="Dose Change"
                                        data-id="21863"><i class="fas fa-edit"></i></span>

                                </td>

                                <td class="text-center">
                                    {{ !empty($ipd_med_item->user_fullname) ? ucfirst($ipd_med_item->user_fullname) : 0 }}
                                </td>
                                <td class="text-center">
                                    {{ !empty($ipd_med_item->au_entry_at) ? date('h:i:s a', strtotime($ipd_med_item->au_entry_at)) : 0 }}
                                </td>

                            </tr>
                        @endforeach


                        @php

                            $redirect_url = route('ipd.nurse-station-patient-details', [reset($ipd_med_list)->patient_no_fk, reset($ipd_med_list)->admission_pk_no]);

                        @endphp
                    @endif

                    @if (isset($extra_med) && !empty($extra_med))
                        @php
                            $start_sl = !empty($ipd_med_list) ? count($ipd_med_list) + 1 : 0;
                        @endphp
                        @foreach ($extra_med as $value)
                            @if ($value->continue_ind == 1)
                                <tr style="background-color: rgb(245, 245, 170)">
                                    <td class="center">{{ $start_sl++ }}</td>
                                    <td class="text-left">
                                        {{ !empty($value->au_entry_at) ? date('d/m/Y', strtotime($value->au_entry_at)) : '' }}
                                    </td>
                                    <td class="text-left">
                                        {{ !empty($value->au_entry_at) ? date('h:i:s a', strtotime($value->au_entry_at)) : '' }}
                                    </td>
                                    <td class="text-left">{{ !empty($value->brand_name) ? $value->brand_name : '' }}</td>
                                    <td class="text-right">{{ !empty($value->dosage) ? $value->dosage : '' }}</td>
                                    <td class="text-right">
                                        {{ !empty($value->duration) ? $value->duration : '' }}&nbsp;<small>{{ !empty($value->duration_mu) ? $value->duration_mu : '' }}</small>
                                    </td>
                                    <td class="text-right">
                                        {{ !empty($value->item_qty) ? $value->item_qty : '' }}&nbsp;<small>{{ !empty($value->uom_txt) ? $value->uom_txt : '' }}</small>
                                    </td>
                                    <td class="text-left">
                                        {{ !empty($value->instruction_take) ? $value->instruction_take : '' }}</td>
                                    <td class="text-left">
                                        {{ !empty($value->ipd_instructed_doc_name) ? $value->ipd_instructed_doc_name : '' }}&nbsp;<small>({{ !empty($value->ipd_instruct_media_name) ? $value->ipd_instruct_media_name : '' }})</small>
                                    </td>
                                    <td class="text-center">
                                        {{-- {{ !empty($value->ret_quantity)? $value->ret_quantity: 0 }}&nbsp;<small>{{ !empty($value->uom_txt)? $value->uom_txt: '' }}</small> --}}
                                    </td>
                                    <td class="text-center">
                                        {{-- {{ !empty($value->current_qty)? $value->current_qty: 0 }}&nbsp;<small>{{ !empty($value->uom_txt)? $value->uom_txt: '' }}</small> --}}
                                    </td>
                                    <td>
                                        {{-- <input type="hidden" name="item_id_{{$value->prescription_med_no_pk}}" value="{{$value->item_no_fk}}">
                            <input type="text" name="indent_qty_{{$value->prescription_med_no_pk}}" id="indent_qty" value="" placeholder="Enter Indent Qty" class="form-control number_only text-right">
                            <input type="hidden" name="uom_{{$value->prescription_med_no_pk}}" value="{{$value->uom_no_fk}}"> --}}

                                    </td>
                                    <td class="text-center">

                                        {{-- <input type="checkbox" name="indent_req[]" id="indent_req" value="{{$value->prescription_med_no_pk}}"> --}}
                                    </td>
                                    <td class="text-center">
                                        {{-- <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" id="remove-item-btn" data-value-med ="{{$value->prescription_med_no_pk}}" data-value-admission ="{{$value->admission_pk_no}}" data-value-patient ="{{$value->patient_no_fk}}" title="Remove"><i class="fa fa-times-circle">discontinue</i></a> --}}

                                        <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn"
                                            id="remove-item-btn" data-value-med="{{ $value->prescription_med_no_pk }}"
                                            data-value-admission="{{ $value->admission_pk_no }}"
                                            data-value-patient="{{ $value->patient_no_fk }}" title="Remove"><i
                                                class="fa fa-times-circle">discontinue</i></a>

                                        <span class="open-modal btnView btn btn-sm btn-info ml-1"
                                            data-action="{{ route('ipd.medicine-dose-edit', $value->prescription_med_no_pk) }}"
                                            data-modal="common-modal-md" data-title="Dose Change" title="Dose Change"
                                            data-id="21863"><i class="fas fa-edit"></i></span>
                                    </td>
                                    <td class="text-center">
                                        {{ !empty($value->user_fullname) ? ucfirst($value->user_fullname) : 'N/A' }}</td>
                                    <td class="text-center">
                                        {{ !empty($value->au_entry_at) ? date('h:i:s a', strtotime($value->au_entry_at)) : 0 }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif

                </tbody>
            </table>
            @if (!empty($ipd_med_list))
                <button type="submit" class="btn btn-md btn-info"
                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">
                    Save</button>
            @endif
        </form>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    function getStore(element) {
        var id = $(element).find(":selected").val();
        $('#phr_department_id').val(id);

    }


function indentItemCount(element) {
    var indent_qty = $(element).val();
    var qty = $(element).closest("tr").find(".qty_val").text();
console.log(qty)
    }


    $(function() {
        var id = $('#store_from').find(":selected").val();
        $('#phr_department_id').val(id);
    });
    $('.select2').select2({});


    $('#selectAllMedicine').click(function(e) {
        var table = $(e.target).closest('table');
        $('td input:checkbox', table).prop('checked', this.checked);
    });

</script>
