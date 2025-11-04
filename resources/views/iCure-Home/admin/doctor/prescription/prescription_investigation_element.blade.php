@php $action_url = route('physiotherapy.load-pres-favourit-list'); @endphp
<div class="card-body p-2 border-top pt-1">
    <div class="form-row">
        <div class="col-md-4">
            <div class="form-group mb-0">
                <label for="clinical_disease" class="col-form-label col-form-label-sm d-block">Investigation <span class="float-right"><a href="#" data-toggle="modal" data-target="#radiologyPathologyReport"><i class="fa fa-angle-double-right font-size-14"></a></i></span></label>
                <input type="text" class="form-control mb-0" id="investigation_item" name="investigation_item" placeholder="Enter Investigation Name" onclick="prescriptionFunc.loadToPresFavouritList(this,'RAD,LAB','Investigation','#investigation', '{{ $action_url }}')">
            </div>
            <div class="form-group mb-0">
                @if (!empty($in_arr))
                @php
                $class = !empty($in_arr) ? ' border p-1' : '';
                @endphp
                <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="investigation">
                    @foreach ($in_arr as $code => $rows)
                    @foreach ($rows as $row)
                    @php
                    $row_data = explode('_', $row);
                    @endphp
                    <li id="item-{{ $row_data[0] }}">
                        <input type="hidden" name="item_id[]" value="{{ $row_data[0] }}" readonly="readonly">
                        <input type="hidden" name="item_name[]" value="{{ $row_data[1] }}" readonly="readonly" class="left-element">
                        <input type="hidden" name="lookup_id[]" value="{{ $row_data[2] }}" readonly="readonly">
                        <input type="hidden" name="lookup_code[]" value="{{ $code }}"readonly="readonly">
                        <input type="hidden" name="lookupdata_code[]" value="{{ $row_data[3] }}" readonly="readonly">
                        <input type='hidden' class='' id='' name='unit_intensity[]'>
                 <input type='hidden'  class='' id='' name='session_duration[]'>
                 <input type='hidden' class='' id=''  name='no_of_session[]'>
                 <input type='hidden' class='' id='' name='session_mu[]'>
                        <i class="fa fa-angle-double-right"></i> {{ $row_data[1] }}&nbsp;&nbsp;
                        <span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span>&nbsp;<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="{{ $add_to_pres_url }}" data-id="{{ $row_data[0] }}" data-name="{{ $row_data[1] }}" data-type="{{ $code }}"><i class="fa fa-star text-primary"></i></span>
                    </li>
                    @endforeach
                    @endforeach
                </ul>
                @else
                <ul class="list-unstyled mb-0 pt-1" id="investigation"></ul>
                @endif
            </div>
        </div>
        <div class="col-md-4">

            <div class="form-group mb-0">
                <label for="clinical_disease" class="col-form-label col-form-label-sm">Investigation Findings</label>
                <input type="text" class="form-control mb-0" id="investigation_findings" name="investigation_findings" placeholder="Write Investigation Findings"
                onclick="prescriptionFunc.loadToPresFavouritList(this,'INVFIND','Inv. Findings','#investigation_find_con', '{{ $action_url }}')"
                data-lookup-id="{{ !empty($lookup_id_arr->INVFIND)?$lookup_id_arr->INVFIND:"" }}" data-lookup-code="INVFIND">
                <div class="card mt-0" style="box-shadow:initial;">
                    <div class="card-body p-0">
                        @if (!empty($inf_arr))
                        @php
                        $class = !empty($inf_arr) ? ' border p-1' : '';
                        @endphp
                        <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="investigation_find_con">
                            @foreach ($inf_arr as $rows)
                            @foreach ($rows as $row)
                            @php
                            $row_data = explode('_', $row);
                            @endphp
                            <li id="item-{{ $row_data[0] }}">
                                <input type="hidden" name="item_id[]" value="{{ $row_data[0] }}"
                                readonly="readonly">
                                <input class="left-element" type="hidden" name="item_name[]"
                                value="{{ $row_data[1] }}" readonly="readonly">
                                <input type="hidden" name="lookup_id[]" value="{{ $row_data[2] }}"
                                readonly="readonly">
                                <input type="hidden" name="lookup_code[]" value="INVFIND"
                                readonly="readonly">
                                <input type="hidden" name="lookupdata_code[]" value="{{ $row_data[3] }}"
                                readonly="readonly">
                                <input type='hidden' class='' id='' name='unit_intensity[]'>
                 <input type='hidden'  class='' id='' name='session_duration[]'>
                 <input type='hidden' class='' id=''  name='no_of_session[]'>
                 <input type='hidden' class='' id='' name='session_mu[]'>
                                <i class="fa fa-angle-double-right"></i> {{ $row_data[1] }}&nbsp;&nbsp;
                                <span class="float-right text-danger cursor-pointer"
                                title="Remove This Item" onclick="removeParentElement(this)"><i
                                class="fa fa-times"></i></span>&nbsp;<span
                                class="float-right text-secondary mr-1 cursor-pointer"
                                style="font-size:11px;" title="Add To Favourite List"
                                onclick="prescriptionFunc.addToPresFavouritList(this)"
                                data-url="{{ $add_to_pres_url }}" data-id="{{ $row_data[0] }}"
                                data-name="{{ $row_data[1] }}" data-type="INVFIND"><i
                                class="fa fa-star text-primary"></i></span>
                            </li>
                            @endforeach
                            @endforeach
                        </ul>
                        @else
                        <ul class="list-unstyled mb-0 pt-1" id="investigation_find_con"></ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-0">
                <label for="clinical_disease" class="col-form-label col-form-label-sm">Note</label>
                <input type="text" class="form-control mb-0" id="investigation_note" name="investigation_note"
                placeholder="Write Investigation Note">
            </div>
        </div>
    </div>
</div>
@if (Session::get('user.su_pk_no') == 1099 || Session::get('user.serviceunit') == "")
<div class="row">
    <div class="col-md-12">
        <table class="table border-0 m-0">
            <thead>
                <tr class="border-0">
                    <th class="p-0 px-1 border-0" width="43%" scope="col">
                        Electro Therapy
                        {{-- <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-md"
                            data-action="{{ route('item.create-quick-item') }}" data-title="Create New Item">+
                            New</span> --}}

                    </th>
                    <th class="border-0"></th>
                    <th class="p-0 px-1 border-0" width="20%" scope="col">Unit/Intensity </th>
                    <th class="p-0 px-1 border-0" width="20%" scope="col">Duration MU</th>
                    <th class="p-0 px-1 border-0" width="15%" scope="col">Duration</th>
                    <th class="p-0 px-1 border-0" scope="col"></th>
                </tr>
            </thead>
            <tbody id="data-append-to">
                <tr class="border-0" id="1">
                    <td scope="row" class="p-0 px-1 border-0" >
                        {{-- <input type="text" class="form-control et_item_name item_element" id="et_item_name_1"
                            name="et_item_name[]"> --}}

                            <input type="text" class="form-control mb-0 et_item_name item_element" id="et_item_name_1" name="et_item_name[]"
                            placeholder="Enter   Electro Therapy Name" lookup-code="PTET"
                            data-append-id="investigation" onclick="prescriptionFunc.loadToPresFavouritList(this,'PTET','Investigation','#et_item_name_1', '{{ $action_url }}')">


                        <input type="hidden" class="form-control left-element" id="hdn_item_id_1" name="item_id[]">
                        <input type="hidden" class="form-control" id="hdn_item_name_1" name="item_name[]">
                        <input type="hidden" class="form-control" id="hdn_lookup_id_1" name="lookup_id[]"
                            value="{{ isset($tr_lk_id_arr['PTET']) ? $tr_lk_id_arr['PTET'] : '' }}">
                        <input type="hidden" class="form-control" id="hdn_lookup_code_1" name="lookup_code[]"
                            value="">
                        <input type="hidden" class="form-control" id="hdn_lookupdata_code_1"
                            name="lookupdata_code[]">
                        {{-- <input type="hidden" class="form-control" id="session_mu_1" name="session_mu[]"> --}}
                        <input type="hidden" class="form-control" id="no_of_session_1" name="no_of_session[]">

                    </td>
                    <td id="ptet_favourit_1" class="border-0"></td>

                    <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                            id="session_duration_1" name="session_duration[]"></td>
                    <td class="p-0 px-1 border-0">

                        <select class="form-control" id="unit_intensity_mu_1" name="session_mu[]">
                            <option value="0">Select</option>
                            @if (!empty($duration_mu_phy))
                                @foreach ($duration_mu_phy as $key => $dmu)
                                    <option value="{{ $key }}">{{ $dmu }}</option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                    <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                            id="unit_intensity_1" name="unit_intensity[]"></td>
                    <td class="p-0 px-1 border-0" style="vertical-align: top;" id="et_td_action_1">
                        <span class="btn btn-success btn-sm" id="ptet_span" onclick="prescriptionFunc.addRow(this, 'ETHER')"   data-favourit-action="{{ route('add-pres-favourit-list') }}"> <i
                                class="fa fa-plus"></i> </span>
                    </td>
                </tr>
                @if (isset($ptet_arr))
                    @foreach ($ptet_arr as $value)
                        @foreach ($value as $row)
                            @php
                                $row_data = explode('_', $row);
                            @endphp
                            <tr class="border-0" id="1">
                                <td scope="row" class="p-0 px-1 border-0">
                                    <input type="text" class="form-control et_item_name item_element"
                                        id="et_item_name_1" name="et_item_name[]" value="{{ $row_data[1] }}">
                                    <input type="hidden" class="form-control left-element" id="" name="item_id[]"
                                        value="{{ $row_data[0] }}">
                                    <input type="hidden" class="form-control" id="" name="item_name[]"
                                        value="{{ $row_data[1] }}">
                                    <input type="hidden" class="form-control" id="hdn_lookup_id_1"
                                        name="lookup_id[]" value="value=" {{ $row_data[2] }}"">
                                    <input type="hidden" class="form-control" id="hdn_lookup_code_1"
                                        name="lookup_code[]" value="PTET">
                                    <input type="hidden" class="form-control" id="hdn_lookupdata_code_1"
                                        name="lookupdata_code[]" value="{{ $row_data[3] }}">
                                    {{-- <input type="hidden" class="form-control" id="session_mu_1"
                                        name="session_mu[]"> --}}
                                    <input type="hidden" class="form-control" id="no_of_session_1"
                                        name="no_of_session[]">
                                </td>
                                <td class="border-0"></td>
                                <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                                        id="session_duration_1" name="session_duration[]" value="{{$row_data[4]}}"></td>
                                <td class="p-0 px-1 border-0">

                                    <select class="form-control" id="unit_intensity_mu_1"
                                        name="session_mu[]">
                                        <option value="0">Select</option>
                                        @if (!empty($duration_mu_phy))
                                            @foreach ($duration_mu_phy as $key => $dmu)
                                                <option value="{{ $key }}" @if ($row_data[5] == $key) selected @endif>{{ $dmu }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </td>
                                <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                                        id="unit_intensity_1" name="unit_intensity[]" value="{{$row_data[7]}}"></td>
                                <td class="p-0 px-1 border-0" style="vertical-align: top;" id="et_td_action_1">
                                    {{-- <span class="btn btn-success btn-sm"
                                        onclick="prescriptionFunc.addRow(this, 'ETHER')"> <i
                                            class="fa fa-plus"></i> </span> --}}

                                            <span class="btn btn-danger btn-sm" onclick="removeTableRowOnly(this)"> <i class="fa fa-times"></i> </span>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table border-0 m-0">
            <thead>
                <tr class="border-0">
                    <th class="p-0 px-1 border-0" width="43%" scope="col">
                        Therapeutic Excercise / Package
                        {{-- <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-sm"
                            data-id="1" data-action="{{ route('doctor.createquickregistration', 1) }}"
                            data-title="Add New Doctor">+ New</span> --}}
                    </th>
                    <th class="border-0"></th>
                    <th class="p-0 px-1 border-0" width="20%" scope="col"> No of Session </th>
                    <th class="p-0 px-1 border-0" width="20%" scope="col">Duration MU</th>
                    <th class="p-0 px-1 border-0" width="15%" scope="col">Session Duration</th>
                    <th class="p-0 px-1 border-0" scope="col"></th>
                </tr>
            </thead>
            <tbody id="data-append-to">
                <tr class="border-0" id="1">
                    <td scope="row" class="p-0 px-1 border-0">
                        <input type="text" class="form-control item_element" id="te_item_name_1"
                            name="te_item_name[]" lookup-code="PTTE" data-append-id="investigation" onclick="prescriptionFunc.loadToPresFavouritList(this,'PTTE','Investigation','#et_item_name_1', '{{ $action_url }}')" placeholder="Enter  Therapeutic Excercise / Package">


                        <input type="hidden" class="form-control left-element" id="hdn_item_id_1" name="item_id[]">
                        <input type="hidden" class="form-control" id="hdn_item_name_1" name="item_name[]">
                        <input type="hidden" class="form-control" id="hdn_lookup_id_1" name="lookup_id[]"
                            value="{{ isset($tr_lk_id_arr['PTTE']) ? $tr_lk_id_arr['PTTE'] : '' }}">
                        <input type="hidden" class="form-control" id="hdn_lookup_code_1" name="lookup_code[]"
                            value="">
                        <input type="hidden" class="form-control" id="hdn_lookupdata_code_1"
                            name="lookupdata_code[]">
                        {{-- <input type="hidden" class="form-control" id="unit_intensity_mu_1"
                            name="unit_intensity_mu[]"> --}}
                        <input type="hidden" class="form-control" id="unit_intensity_1" name="unit_intensity[]">

                    </td>
                    <td id="ptte_favourit_1" class="border-0"></td>

                    <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                            id="session_duration_1" name="session_duration[]"></td>
                    <td class="p-0 px-1 border-0">
                        <select class="form-control" id="session_mu_1" name="session_mu[]">
                            <option value="0">Select</option>
                            @if (!empty($duration_mu_phy))
                                @foreach ($duration_mu_phy as $key => $dmu)
                                    <option value="{{ $key }}">{{ $dmu }}</option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                    <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                            id="no_of_session_1" name="no_of_session[]"></td>
                    <td class="p-0 px-1 border-0" style="vertical-align: top;" id="te_td_action_1">
                        <span class="btn btn-success btn-sm" id="ptte_span" onclick="prescriptionFunc.addRow(this, 'THRPEX')" data-favourit-action="{{ route('add-pres-favourit-list') }}"> <i
                                class="fa fa-plus"></i> </span>
                    </td>
                </tr>
                @if (isset($ptte_arr))

                    @foreach ($ptte_arr as $value)
                        @foreach ($value as $row)
                            @php
                                $row_data = explode('_', $row);

                            @endphp
                            <tr class="border-0" id="1">
                                <td scope="row" class="p-0 px-1 border-0">
                                    <input type="text" class="form-control item_element" id="te_item_name_1"
                                        name="te_item_name[]" value="{{$row_data[1]}}">
                                    <input type="hidden" class="form-control left-element" id="hdn_item_id_1"
                                        name="item_id[]" value="{{$row_data[0]}}">
                                    <input type="hidden" class="form-control" id="hdn_item_name_1"
                                        name="item_name[]" value="{{$row_data[1]}}">
                                    <input type="hidden" class="form-control" id="hdn_lookup_id_1"
                                        name="lookup_id[]" value="{{$row_data[2]}}">
                                    <input type="hidden" class="form-control" id="hdn_lookup_code_1"
                                        name="lookup_code[]" value="PTTE">
                                    <input type="hidden" class="form-control" id="hdn_lookupdata_code_1"
                                        name="lookupdata_code[]" value="{{$row_data[3]}}">
                                    {{-- <input type="hidden" class="form-control" id="unit_intensity_mu_1"
                                        name="unit_intensity_mu[]"> --}}
                                    <input type="hidden" class="form-control" id="unit_intensity_1"
                                        name="unit_intensity[]">
                                </td>
                                <td class="border-0"></td>
                                <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                                        id="session_duration_1" name="session_duration[]" value="{{$row_data[4]}}"></td>
                                <td class="p-0 px-1 border-0">
                                    <select class="form-control" id="session_mu_1" name="session_mu[]">
                                        <option value="0">Select</option>
                                        @if (!empty($duration_mu_phy))
                                            @foreach ($duration_mu_phy as $key => $dmu)
                                                <option value="{{ $key }}" @if ( $row_data[5] == $key)  selected @endif>{{ $dmu }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </td>
                                <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only"
                                        id="no_of_session_1" name="no_of_session[]" value="{{$row_data[6] }}"></td>
                                <td class="p-0 px-1 border-0" style="vertical-align: top;" id="te_td_action_1">
                                    {{-- <span class="btn btn-success btn-sm"
                                        onclick="prescriptionFunc.addRow(this, 'THRPEX')"> <i
                                            class="fa fa-plus"></i> </span> --}}
                                            <span class="btn btn-danger btn-sm" onclick="removeTableRowOnly(this)"> <i class="fa fa-times"></i> </span>
                                </td>
                            </tr>

                        @endforeach
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endif




<!-- Radiology & Pathology Report Print Modal -->
<div class="modal fade" id="radiologyPathologyReport" tabindex="-1" role="dialog"
aria-labelledby="radiologyPathologyReportTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLongTitle">Radiology & Pathology Report Print</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="col-md-6">
                    <label for="department" class="col-form-label col-form-label-sm d-block">Department</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="reportType" id="reportTypeRadiology"
                        value="">
                        <label class="form-check-label" for="reportTypeRadiology">Radiology</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="reportType" id="reportTypePathology"
                        value="">
                        <label class="form-check-label" for="reportTypePathology">Pathology</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="department" class="col-form-label col-form-label-sm">Department</label>
                    <select class="form-control" id="department" name="department">
                        <option value="0">Select Department</option>
                        <option value="">Department-1</option>
                        <option value="">Department-2</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="modal-footer py-1">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>
</div>
