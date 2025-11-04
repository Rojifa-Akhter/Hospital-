<div class="col-md-12 col-lg-12 col-sm-12">
    <div class="row">


    </div>
</div>

<input type="hidden" id="hdn_pres_route_inv" value="{{ route('add-pres-favourit-list') }}" />
<div class="card-body border-top pt-1">
    @if (!empty($su_info) && $su_info->physio_ind == 1)
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <table class="table border-0 m-0">
                    <thead>
                        <tr class="border-0">
                            <th class="p-0 px-1 border-0" width="15%">
                                <span style="font-size: 11px; white-space: nowrap;">Modern Traditional Chinese</span>
                                <span style="font-size: 11px;">Medicine(TCM):</span>

                            </th>
                            <th class="border-0"></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Frequency</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Mode</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Unit/Intensity</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Repetition</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Duration</span></th>
                            <th class="p-0 px-1 border-0"><span style="font-size: 11px; white-space: nowrap;">Duration
                                    MU</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Session/Days</span></th>
                            <th class="p-0 px-1 border-0"></th>
                        </tr>
                    </thead>
                    <tbody id="data-append-to-physio" class="data-append-to-physio-acup">
                        <tr class="border-0" id="1">
                            <td scope="row" class="p-0 px-1 border-0">
                                <input type="text" class="form-control item_element" id="acup_item_name_1"
                                    name="acup_item_name[]"
                                    placeholder="Enter Mordern Traditional Chinese Medicine Name" lookup-code="ACUP"
                                    data-append-id="investigation"
                                    onkeyup="prescriptionFunc.addNotFoundAcupItem(event,this)"
                                    onclick="prescriptionFunc.loadToPresFavouritList(this,'ACUP','Investigation','#acup_item_name_1', '{{ $action_url }}')">

                                <input type="hidden" class="form-control left-element" id="hdn_item_id_1"
                                    name="">
                                <input type="hidden" class="form-control" id="hdn_item_name_1" name="">
                                <input type="hidden" class="form-control" id="hdn_lookup_id_1" name=""
                                    value="{{ isset($tr_lk_id_arr['ACUP']) ? $tr_lk_id_arr['ACUP'] : '' }}">
                                <input type="hidden" class="form-control" id="hdn_lookup_code_1" name=""
                                    value="">
                                <input type="hidden" class="form-control" id="hdn_lookupdata_code_1" name="">
                                <input type="hidden" class="form-control" id="no_of_session_1" name="">
                            </td>
                            <td id="acup_favourit_1" class="border-0"></td>

                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control" id="frequency_1" name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control" id="mode_1" name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control number_only" id="session_duration_1"
                                    name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control" id="in_m_repetition_1" name="">
                                <input type="hidden" class="form-control" id="in_e_location_for_acup_1" name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control number_only" id="unit_intensity_1"
                                    name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <select class="form-control" id="unit_intensity_mu_1" name="">
                                    <option value="0">Select</option>
                                    @if (!empty($duration_mu_phy))
                                        @foreach ($duration_mu_phy as $key => $dmu)
                                            <option value="{{ $key }}">{{ $dmu }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control" id="in_m_duration_1" name="">
                            </td>
                            <td class="p-0 px-1 border-0" style="vertical-align: top;" id="acup_td_action_1">
                                <span class="btn btn-success btn-sm" id="acup_span"
                                    onclick="prescriptionV2.addRow(this, 'ACUP')"
                                    data-favourit-action="{{ route('add-pres-favourit-list') }}"><i
                                        class="fa fa-plus"></i>
                                </span>
                            </td>
                        </tr>
                        @if (isset($acup_arr))
                            @foreach ($acup_arr as $value)
                                @foreach ($value as $row)
                                    @php
                                        $row_data = explode('_', $row);
                                    @endphp
                                    <tr class="border-0" id="1">
                                        <td scope="row" class="p-0 px-1 border-0">
                                            <input type="text" class="form-control acup_item_name item_element"
                                                id="acup_item_name_1" name="acup_item_name[]"
                                                value="{{ $row_data[1] }}">
                                            <input type="hidden" class="form-control left-element" id=""
                                                name="item_id[]" value="{{ $row_data[0] }}">
                                            <input type="hidden" class="form-control" id=""
                                                name="item_name[]" value="{{ $row_data[1] }}">
                                            <input type="hidden" class="form-control" id="hdn_lookup_id_1"
                                                name="lookup_id[]" value="{{ $row_data[2] }}">
                                            <input type="hidden" class="form-control" id="hdn_lookup_code_1"
                                                name="lookup_code[]" value="ACUP">
                                            <input type="hidden" class="form-control" id="hdn_lookupdata_code_1"
                                                name="lookupdata_code[]" value="{{ $row_data[3] }}">

                                            <input type="hidden" class="form-control" id="no_of_session_1"
                                                name="no_of_session[]">
                                        </td>
                                        <td class="border-0"></td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control" id="frequency_1"
                                                name="frequency[]" value="{{ $row_data[8] }}">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control" id="mode_1" name="mode[]"
                                                value="{{ $row_data[9] }}">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control number_only"
                                                id="session_duration_1" name="session_duration[]"
                                                value="{{ $row_data[4] }}">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control" id="in_m_repetition_1"
                                                name="in_m_repetition[]" value="{{ $row_data[10] }}">
                                            <input type="hidden" class="form-control" id="in_e_location_for_acup_1"
                                                name="in_e_location[]">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control number_only"
                                                id="unit_intensity_1" name="unit_intensity[]"
                                                value="{{ $row_data[7] }}">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <select class="form-control" id="unit_intensity_mu_1"
                                                name="session_mu[]">
                                                <option value="0">Select</option>
                                                @if (!empty($duration_mu_phy))
                                                    @foreach ($duration_mu_phy as $key => $dmu)
                                                        <option value="{{ $key }}"
                                                            @if ($row_data[5] == $key) selected @endif>
                                                            {{ $dmu }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control" id="in_m_duration_1"
                                                name="in_m_duration[]" value="{{ $row_data[12] }}">
                                        </td>
                                        <td class="p-0 px-1 border-0" style="vertical-align: top;"
                                            id="acup_td_action_1">
                                            <span class="btn btn-danger btn-sm" onclick="removeTableRowOnly(this)">
                                                <i class="fa fa-times"></i>
                                            </span>
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
            <div class="col-md-12 col-sm-12 col-lg-12">
                <table class="table border-0 m-0">
                    <thead>
                        <tr class="border-0">
                            <th class="p-0 px-1 border-0" width="15%">
                                <span style="font-size: 11px; white-space: nowrap;">Electro Therapy</span>
                            </th>
                            <th class="border-0"></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Frequency</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Mode</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Unit/Intensity</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Location/Area</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Duration</span></th>
                            <th class="p-0 px-1 border-0"><span style="font-size: 11px; white-space: nowrap;">Duration
                                    MU</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Session/Days</span></th>
                            <th class="p-0 px-1 border-0"></th>
                        </tr>
                    </thead>
                    <tbody id="data-append-to-physio" class="data-append-to-physio-ptet">
                        <tr class="border-0" id="1">
                            <td scope="row" class="p-0 px-1 border-0">
                                <input type="text" class="form-control mb-0 et_item_name item_element"
                                    id="et_item_name_1" name="et_item_name[]"
                                    placeholder="Enter Electro Therapy Name" lookup-code="PTET"
                                    data-append-id="investigation"
                                    onkeyup="prescriptionFunc.addNotFoundPhyElecItem(event,this)"
                                    onclick="prescriptionFunc.loadToPresFavouritList(this,'PTET','Investigation','#et_item_name_1', '{{ $action_url }}')">

                                <input type="hidden" class="form-control left-element" id="et_hdn_item_id_1"
                                    name="">
                                <input type="hidden" class="form-control" id="et_hdn_item_name_1" name="">
                                <input type="hidden" class="form-control" id="et_hdn_lookup_id_1" name=""
                                    value="{{ isset($tr_lk_id_arr['PTET']) ? $tr_lk_id_arr['PTET'] : '' }}">
                                <input type="hidden" class="form-control" id="et_hdn_lookup_code_1" name=""
                                    value="">
                                <input type="hidden" class="form-control" id="et_hdn_lookupdata_code_1"
                                    name="">
                                <input type="hidden" class="form-control" id="et_no_of_session_1" name="">
                            </td>
                            <td id="ptet_favourit_1" class="border-0"></td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control" id="et_frequency_1" name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control" id="et_mode_1" name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control number_only" id="et_session_duration_1"
                                    name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control" id="in_e_location_1" name="">
                                <input type="hidden" class="form-control" id="in_m_repetition_loc_1"
                                    name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control number_only" id="et_unit_intensity_1"
                                    name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <select class="form-control" id="et_unit_intensity_mu_1" name="">
                                    <option value="0">Select</option>
                                    @if (!empty($duration_mu_phy))
                                        @foreach ($duration_mu_phy as $key => $dmu)
                                            <option value="{{ $key }}">{{ $dmu }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control" id="in_e_duration_1" name="">
                            </td>
                            <td class="p-0 px-1 border-0" style="vertical-align: top;" id="et_td_action_1">
                                <span class="btn btn-success btn-sm" id="ptet_span"
                                    onclick="prescriptionV2.addRow(this, 'ETHER')"
                                    data-favourit-action="{{ route('add-pres-favourit-list') }}">
                                    <i class="fa fa-plus"></i>
                                </span>
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
                                                id="et_item_name_1" name="et_item_name[]"
                                                value="{{ $row_data[1] }}">
                                            <input type="hidden" class="form-control left-element" id=""
                                                name="item_id[]" value="{{ $row_data[0] }}">
                                            <input type="hidden" class="form-control" id=""
                                                name="item_name[]" value="{{ $row_data[1] }}">
                                            <input type="hidden" class="form-control" id="et_hdn_lookup_id_1"
                                                name="lookup_id[]" value="{{ $row_data[2] }}">
                                            <input type="hidden" class="form-control" id="et_hdn_lookup_code_1"
                                                name="lookup_code[]" value="PTET">
                                            <input type="hidden" class="form-control" id="et_hdn_lookupdata_code_1"
                                                name="lookupdata_code[]" value="{{ $row_data[3] }}">

                                            <input type="hidden" class="form-control" id="et_no_of_session_1"
                                                name="no_of_session[]">
                                        </td>
                                        <td class="border-0"></td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control" id="et_frequency_1"
                                                name="frequency[]" value="{{ $row_data[8] }}">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control" id="et_mode_1" name="mode[]"
                                                value="{{ $row_data[9] }}">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control number_only"
                                                id="et_session_duration_1" name="session_duration[]"
                                                value="{{ $row_data[4] }}">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control" id="in_e_location_1"
                                                name="in_e_location[]" value="{{ $row_data[11] }}">
                                            <input type="hidden" class="form-control" id="in_m_repetition_loc_1"
                                                name="in_m_repetition[]">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control number_only"
                                                id="et_unit_intensity_1" name="unit_intensity[]"
                                                value="{{ $row_data[7] }}">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <select class="form-control" id="et_unit_intensity_mu_1"
                                                name="session_mu[]">
                                                <option value="0">Select</option>
                                                @if (!empty($duration_mu_phy))
                                                    @foreach ($duration_mu_phy as $key => $dmu)
                                                        <option value="{{ $key }}"
                                                            @if ($row_data[5] == $key) selected @endif>
                                                            {{ $dmu }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control" id="in_e_duration_1"
                                                name="in_m_duration[]" value="{{ $row_data[12] }}">
                                        </td>
                                        <td class="p-0 px-1 border-0" style="vertical-align: top;"
                                            id="et_td_action_1">
                                            <span class="btn btn-danger btn-sm" onclick="removeTableRowOnly(this)"><i
                                                    class="fa fa-times"></i>
                                            </span>
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
            <div class="col-md-12 col-lg-12 col-sm-12">
                <table class="table border-0 m-0">
                    <thead>
                        <tr class="border-0">
                            <th class="p-0 px-1 border-0" width="15%">
                                <span style="font-size: 11px; white-space: nowrap;">Therapeutic Exercise</span>
                                {{-- <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-sm"
                            data-id="1" data-action="{{ route('doctor.createquickregistration', 1) }}"
                            data-title="Add New Doctor">+ New</span> --}}
                            </th>
                            <th class="border-0"></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Frequency</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Mode</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Unit/Intensity</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Repetition</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Duration</span></th>
                            <th class="p-0 px-1 border-0"><span style="font-size: 11px; white-space: nowrap;">Duration
                                    MU</span></th>
                            <th class="p-0 px-1 border-0"><span
                                    style="font-size: 11px; white-space: nowrap;">Session/Days</span></th>
                            <th class="p-0 px-1 border-0"></th>
                        </tr>
                    </thead>
                    <tbody id="data-append-to-physio" class="data-append-to-physio-ptte">
                        <tr class="border-0" id="1">
                            <td scope="row" class="p-0 px-1 border-0">
                                <input type="text" class="form-control item_element" id="te_item_name_1"
                                    name="te_item_name[]" lookup-code="PTTE" data-append-id="investigation"
                                    onkeyup="prescriptionFunc.addNotFoundPhyTheraputItem(event,this)"
                                    onclick="prescriptionFunc.loadToPresFavouritList(this,'PTTE','Investigation','#te_item_name_1', '{{ $action_url }}')"
                                    placeholder="Enter Therapeutic Excercise / Package">
                                <input type="hidden" class="form-control left-element" id="te_hdn_item_id_1"
                                    name="">
                                <input type="hidden" class="form-control" id="te_hdn_item_name_1" name="">
                                <input type="hidden" class="form-control" id="te_hdn_lookup_id_1" name=""
                                    value="{{ isset($tr_lk_id_arr['PTTE']) ? $tr_lk_id_arr['PTTE'] : '' }}">
                                <input type="hidden" class="form-control" id="te_hdn_lookup_code_1" name=""
                                    value="">
                                <input type="hidden" class="form-control" id="te_hdn_lookupdata_code_1"
                                    name="">
                                <input type="hidden" class="form-control" id="te_unit_intensity_" name="">
                            </td>
                            <td id="ptte_favourit_1" class="border-0"></td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control" id="te_frequency_1" name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control" id="te_mode_1" name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control number_only" id="te_session_duration_1"
                                    name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control" id="in_t_repetition_1" name="">
                                <input type="hidden" class="form-control" id="in_e_location_for_thr_1"
                                    name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control number_only" id="te_no_of_session_1"
                                    name="">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <select class="form-control" id="te_session_mu_1" name="">
                                    <option value="0">Select</option>
                                    @if (!empty($duration_mu_phy))
                                        @foreach ($duration_mu_phy as $key => $dmu)
                                            <option value="{{ $key }}">{{ $dmu }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control" id="in_t_duration_1" name=""
                                    value="">
                            </td>
                            <td class="p-0 px-1 border-0" style="vertical-align: top;" id="te_td_action_1">
                                <span class="btn btn-success btn-sm" id="ptte_span"
                                    onclick="prescriptionV2.addRow(this, 'THRPEX')"
                                    data-favourit-action="{{ route('add-pres-favourit-list') }}"><i
                                        class="fa fa-plus"></i>
                                </span>
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
                                            <input type="text" class="form-control item_element"
                                                id="te_item_name_1" name="te_item_name[]"
                                                value="{{ $row_data[1] }}">
                                            <input type="hidden" class="form-control left-element"
                                                id="te_hdn_item_id_1" name="item_id[]" value="{{ $row_data[0] }}">
                                            <input type="hidden" class="form-control" id="te_hdn_item_name_1"
                                                name="item_name[]" value="{{ $row_data[1] }}">
                                            <input type="hidden" class="form-control" id="te_hdn_lookup_id_1"
                                                name="lookup_id[]" value="{{ $row_data[2] }}">
                                            <input type="hidden" class="form-control" id="te_hdn_lookup_code_1"
                                                name="lookup_code[]" value="PTTE">
                                            <input type="hidden" class="form-control" id="te_hdn_lookupdata_code_1"
                                                name="lookupdata_code[]" value="{{ $row_data[3] }}">
                                            <input type="hidden" class="form-control" id="te_unit_intensity_1"
                                                name="unit_intensity[]">
                                        </td>
                                        <td class="border-0"></td>
                                        <td class="p-0 px-1 border-0"><input type="text" class="form-control"
                                                id="te_frequency_1" name="frequency[]" value="{{ $row_data[8] }}">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control" id="te_mode_1" name="mode[]"
                                                value="{{ $row_data[9] }}">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control number_only"
                                                id="te_session_duration_1" name="session_duration[]"
                                                value="{{ $row_data[4] }}">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control" id="in_t_repetition_1"
                                                name="in_m_repetition[]" value="{{ $row_data[10] }}">
                                            <input type="hidden" class="form-control" id="in_e_location_for_thr_1"
                                                name="in_e_location[]">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control number_only"
                                                id="te_no_of_session_1" name="no_of_session[]"
                                                value="{{ $row_data[6] }}">
                                            <input type="hidden" class="form-control number_only"
                                                id="unit_intensity_for_thr_1" name="unit_intensity[]">

                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <select class="form-control" id="te_session_mu_1" name="session_mu[]">
                                                <option value="0">Select</option>
                                                @if (!empty($duration_mu_phy))
                                                    @foreach ($duration_mu_phy as $key => $dmu)
                                                        <option value="{{ $key }}"
                                                            @if ($row_data[5] == $key) selected @endif>
                                                            {{ $dmu }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>

                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control" id="in_t_duration_1"
                                                name="in_m_duration[]" value="{{ $row_data[12] }}">
                                        </td>

                                        <td class="p-0 px-1 border-0" style="vertical-align: top;"
                                            id="te_td_action_1">
                                            <span class="btn btn-danger btn-sm" onclick="removeTableRowOnly(this)"><i
                                                    class="fa fa-times"></i>
                                            </span>
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
            <div class="col-md-12 col-lg-12 col-sm-12 mt-2">
                <label for=""><strong>Outcome Measurement</strong></label>
                <textarea name="in_outcome_measurement" id="in_outcome_measurement" cols="15" rows="5"
                    class="form-control">{{ isset($lmp->outcome_measurement) ? $lmp->outcome_measurement : '' }}</textarea>
            </div>
        </div>

    @endif

    <div class="form-row">
        <div class="col-md-4 col-lg-4 col-sm-4">
            <div class="card mt-0 bg-none">
                <div class="card-header">
                    <span id="favourit_list_title" data-append-to="">Favourite List</span>
                    <span class="loading-img"></span>
                </div>
                <div class="card-body" style="max-height: 300px; overflow:scroll;">
                    <div class="form-group mt-2">
                        <input type="search" class="form-control form-control-sm " id="favListSearch"
                            name="" onkeyup="favoriteListSearch(this)" searcAttrvalue=''
                            placeholder="Search Favourite Item">
                    </div>
                    <table class="table m-0">
                        <tbody id="pres-favourit-list-investigation" class="pres-favourit-list"
                            style="word-break: break-all;">
                            @include('admin.components.pres_favourit_list')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4 mt-4">
            <div class="form-group mb-0">
                <label for="clinical_disease" class="col-form-label col-form-label-sm d-block mb-1">Investigation /
                    Procedure
                    <a class="btn btn-sm btn-outline-primary open-modal" data-modal="common-modal-md"
                        data-action="{{ route('prescription-most-used-items-uhl', 'INVFIND') }}"
                        data-title="Most Used Investigation" data-append-id="#investigation"
                        onclick="prescriptionFunc.mosUsedIdPass(this)">MUI</a>
                    <a class="btn btn-sm btn-outline-success open-modal" data-modal="common-modal-md"
                        data-action="{{ route('prescription-packages-uhl') }}"
                        data-title="Pakages List" data-append-id="#PKG">Pakages</a></label>

                <input type="text" class="form-control mb-0" id="investigation_item" name="investigation_item"
                    placeholder="Enter Investigation or Procedure Name" lookup-code="INVFIND"
                    data-append-id="investigation"
                    onclick="prescriptionV2.loadToPresFavouritListV2(this,'INVFIND','Investigation','#investigation', '{{ $action_url }}','#pres-favourit-list-investigation')">
            </div>
            <div class="form-group">

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
                                    <input type="hidden" name="item_id[]" value="{{ $row_data[0] }}"
                                        readonly="readonly">
                                    <input class="left-element" type="hidden" name="item_name[]"
                                        value="{{ $row_data[1] }}" readonly="readonly">
                                    <input type="hidden" name="lookup_id[]" value="{{ $row_data[2] }}"
                                        readonly="readonly">
                                    <input type="hidden" name="lookup_code[]" value="{{ $code }}"
                                        readonly="readonly">
                                    <input type="hidden" name="lookupdata_code[]" value="{{ $row_data[3] }}"
                                        readonly="readonly">
                                    <input type='hidden' name='unit_intensity[]'>
                                    <input type='hidden' name='session_duration[]'>
                                    <input type='hidden' name='no_of_session[]'>
                                    <input type='hidden' name='session_mu[]'>
                                    <input type='hidden' name='frequency[]'>
                                    <input type='hidden' name='mode[]'>
                                    <input type='hidden' name='in_m_duration[]'>
                                    <input type='hidden' name='in_m_repetition[]'>
                                    <input type='hidden' name='in_e_location[]'>
                                    <i class="fa fa-angle-double-right"></i> {{ $row_data[1] }}&nbsp;&nbsp;
                                    <span class="float-right text-danger cursor-pointer" title="Remove This Item"
                                        onclick="removeParentElement(this)"><i class="fa fa-times"></i>
                                    </span>
                                    &nbsp;
                                    <span class="float-right text-secondary mr-1 cursor-pointer"
                                        style="font-size:11px;" title="Add To Favourite List"
                                        onclick="prescriptionFunc.addToPresFavouritList(this)"
                                        data-url="{{ $add_to_pres_url }}" data-id="{{ $row_data[0] }}"
                                        data-name="{{ $row_data[1] }}" data-type="{{ $code }}">
                                        <i class="fa fa-star text-primary"></i>
                                    </span>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                @else
                    <ul class="list-unstyled mb-0 pt-1" id="investigation"></ul>
                @endif
            </div>
        </div>
        {{-- {{dd($investigation_findings_note)}} --}}
        <div class="col-md-4 mt-4">
            <div class="form-group mb-0">
                <label for="investigation_findings_txt" class="col-form-label col-form-label-sm">Investigation
                    Findings</label>

                <textarea name="investigation_findings_txt" id="investigation_findings_txt"
                    class="form-control form-control-sm m-0 p-0 item_element mb-0" cols="20" rows="10"
                    placeholder="Enter Investigation Findings">{{ $investigation_findings_note ?? '' }}</textarea>

            </div>
        </div>
        {{-- <div class="col-md-4 mt-4">
            <div class="form-group mb-0">
                <label for="clinical_disease" class="col-form-label col-form-label-sm">Investigation Findings</label>
                <input type="text" class="form-control mb-0" id="investigation_findings"
                    name="investigation_findings" placeholder="Write Investigation Findings"
                    onclick="prescriptionV2.loadToPresFavouritListV2(this,'FINDINGS','Inv. Findings','#investigation_find_con', '{{ $action_url }}','#pres-favourit-list-investigation')"
                    data-lookup-id="{{ $lookup_id_arr->FINDINGS }}" data-lookup-code="FINDINGS">
                <div class="card mt-0">
                    <div class="card-body p-0">
                        @if (!empty($find_arr))
                            @php
                                $class = !empty($find_arr) ? ' border p-1' : '';
                            @endphp
                            <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="investigation_find_con">
                                @foreach ($find_arr as $rows)
                                    @foreach ($rows as $row)
                                        @php
                                            $row_data = explode('_', $row);
                                        @endphp
                                        <li id="item-{{ $row_data[0] }}">
                                            <input type="hidden" name="item_id[]" value="{{ $row_data[0] }}" readonly="readonly">
                                            <input class="left-element" type="hidden" name="item_name[]" value="{{ $row_data[1] }}" readonly="readonly">
                                            <input type="hidden" name="lookup_id[]" value="{{ $row_data[2] }}" readonly="readonly">
                                            <input type="hidden" name="lookup_code[]" value="FINDINGS" readonly="readonly">
                                            <input type="hidden" name="lookupdata_code[]" value="{{ $row_data[3] }}" readonly="readonly">
                                            <input type='hidden' name='unit_intensity[]'>
                                            <input type='hidden' name='session_duration[]'> 
                                            <input type='hidden' name='no_of_session[]'> 
                                            <input type='hidden' name='session_mu[]'>
                                            <input type='hidden' name='frequency[]'>
                                            <input type='hidden' name='mode[]'>
                                            <input type='hidden' name='in_m_duration[]'>
                                            <input type='hidden' name='in_m_repetition[]'>
                                            <input type='hidden' name='in_e_location[]'>
                                            <i class="fa fa-angle-double-right"></i> {{ $row_data[1] }}&nbsp;&nbsp;
                                            <span class="float-right text-danger cursor-pointer"
                                                title="Remove This Item" onclick="removeParentElement(this)">
                                                <i class="fa fa-times"></i>
                                            </span>&nbsp;
                                            <span
                                                class="float-right text-secondary mr-1 cursor-pointer"
                                                style="font-size:11px;" title="Add To Favourite List"
                                                onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                data-url="{{ $add_to_pres_url }}" data-id="{{ $row_data[0] }}"
                                                data-name="{{ $row_data[1] }}" data-type="FINDINGS">
                                                <i class="fa fa-star text-primary"></i>
                                            </span>
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
        </div> --}}
    </div>

</div>


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
                            <input class="form-check-input" type="radio" name="reportType"
                                id="reportTypeRadiology" value="">
                            <label class="form-check-label" for="reportTypeRadiology">Radiology</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="reportType"
                                id="reportTypePathology" value="">
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

<script>
    function handleAcupName(val) {
        alert('Hello ' + val);
    }

    function pakageListShow(thisElement) {
        var id = $(thisElement).attr("data-append-id");
        $("#favourit_list_title").attr("data-append-to", id);
    }
</script>
