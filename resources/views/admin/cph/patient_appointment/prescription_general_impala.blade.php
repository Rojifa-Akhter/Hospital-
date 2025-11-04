<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<div class="card-body border-top">
    <h4>R<sub>x</sub></h4>
    <div class="row">
        <div class="col-md-12">
            <table class="table border-0 mt-2 mb-0">
                <thead>
                    <tr class="border-0">
                        <th class="p-0 border-0 w-35" colspan="2">Medicine</th>
                        <th class="p-0 px-1 border-0 w-12">Route</th>
                        <th class="p-0 px-1 border-0 w-12">Dose</th>
                        <th class="p-0 px-1 border-0 w-20">Duration</th>
                        <th class="p-0 px-1 border-0 w-8" hidden>Qty.</th>
                        <th class="p-0 px-1 border-0">Instruction</th>
                        <th class="p-0 px-1 border-0">Continue</th>
                        {{-- <th class="p-0 px-1 border-0">Chronic</th> --}}
                        <th class="p-0 px-1 border-0"></th>
                    </tr>
                </thead>
                <tbody id="data-append-to">
                    <tr class="border-0" id="0">
                        <td class="p-0 border-0">
                            <input type="text"
                                class="form-control form-control-sm m-0 p-0 item_element text-capitalize"
                                id="medicine_item_0" name="medicine_item[]" placeholder="Generic / Brand"
                                onclick="prescriptionFunc.loadToPresFavouritList(this,'MED','Medicine','#data-append-to', '{{ $action_url }}')">

                            <input type="hidden" id="hdn_medicine_item_id_0" name="hdn_medicine_item_id[]">
                            <input type="hidden" id="hdn_report_serial_med_0" name="hdn_report_serial_med[]"
                                value="1">
                            <input type="hidden" id="hdn_medicine_item_id" name="hdn_medicine_item_id_[]"
                                value="">
                            <input type="hidden" id="hidden_multidose_id_0" value="" name="multidose[]">
                        </td>
                        <td class="p-0 border-0" id="med_favourit_0" style="vertical-align: top;">&nbsp;</td>
                        <td class="p-0 px-1 border-0">


                            <select class="form-control form-control-sm select2 m-0 p-0 medicine_route"
                                id="medicine_route_0" name="medicine_route[]"
                                onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');">
                                <option value="0">Select</option>

                                @if (!empty($route))
                                    @foreach ($route as $key => $dmu)
                                        @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                                            @if ($dmu['entry'] == Auth::id())
                                                <option value="{{ $key }}">{{ $dmu['data'] }}</option>
                                            @endif
                                        @else
                                            <option value="{{ $key }}">{{ $dmu['data'] }}</option>
                                        @endif
                                    @endforeach
                                @endif
                                <option data-qnty="0" data-dropdown_option="add_more"
                                    data-popup_header="Medicine Route" data-input_label="Route"
                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">
                                    Add
                                    More</option>
                            </select>
                        </td>

                        <td class="p-0 px-1 border-0">
                            <select class="form-control select2 m-0 p-0 medicine_dose" id="medicine_dose_0"
                                name="medicine_dose[]"
                                onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose');prescriptionFunc.calculateMedicineQnty(this)">
                                <option value="0">Select</option>
                                @if (!empty($dose))
                                    @foreach ($dose as $key => $dmu)
                                        @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                                            @if ($dmu['entry'] == Auth::id())
                                                <option value="{{ $key }}">{{ $dmu['data'] }}</option>
                                            @endif
                                        @else
                                            <option value="{{ $key }}">{{ $dmu['data'] }}</option>
                                        @endif
                                    @endforeach
                                @endif
                                <option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Dose"
                                    data-input_label="Dose"
                                    data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                    value="0">Add More</option>
                            </select>
                        </td>
                        <option value="0">Select</option>

                        <td class="p-0 px-1 border-0">
                            <div class="input-group">
                                <input type="text"
                                    class="form-control form-control-sm m-0 p-0 medicine_duration number_only"
                                    id="medicine_duration_type_0" name="medicine_duration_type[]"
                                    onkeyup="prescriptionFunc.calculateMedicineQnty(this)">
                                <select class="form-control medicine_duration_mu" id="medicine_duration_mu_0"
                                    name="medicine_duration_mu[]"
                                    onchange="prescriptionFunc.calculateMedicineQnty(this)">
                                    <option value="0">Select</option>
                                    @if (!empty($meddurmu))
                                        @foreach ($meddurmu as $key => $dmu)
                                            @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                                                @if (strtoupper($key) == 'DAY')
                                                    <option value="{{ strtoupper($key) }}" selected="selected">
                                                        {{ $dmu['data'] }}</option>
                                                @else
                                                    <option value="{{ strtoupper($key) }}">{{ $dmu['data'] }}
                                                    </option>
                                                @endif
                                            @else
                                                @if (strtoupper($key) == 'DAY')
                                                    <option value="{{ strtoupper($key) }}" selected="selected">
                                                        দিন</option>
                                                @else
                                                    <option value="{{ strtoupper($key) }}">
                                                        @if ($dmu['data'] == 'Day')
                                                            দিন
                                                        @elseif($dmu['data'] == 'Hour')
                                                            ঘন্টা
                                                        @elseif($dmu['data'] == 'Week')
                                                            সপ্তাহ
                                                        @else
                                                            মাস
                                                        @endif
                                                    </option>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                        </td>

                        <td class="p-0 px-1 border-0" hidden> {{-- hidden for ewmch requ --}}
                            <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity"
                                id="medicine_quantity_0" name="medicine_quantity[]">
                        </td>

                        <td class="p-0 px-1 border-0">
                            <select class="form-control form-control-sm select2 m-0 p-0 medicine_instruction"
                                id="instruction_0" name="instruction[]"
                                onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');">
                                <option value="0">Select</option>
                                @if (!empty($instructions))
                                    @foreach ($instructions as $key => $dmu)
                                        @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                                            @if ($dmu['entry'] == Auth::id())
                                                <option value="{{ $key }}">{{ $dmu['data'] }}</option>
                                            @endif
                                        @else
                                            <option value="{{ $key }}">{{ $dmu['data'] }}</option>
                                        @endif
                                    @endforeach
                                @endif
                                <option data-qnty="0" data-dropdown_option="add_more"
                                    data-popup_header="Medicine Instruction" data-input_label="Instruction"
                                    data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal..)"
                                    value="0">Add More</option>
                            </select>
                        </td>

                        <td class="p-0 px-1 border-0 text-center">
                            <input type="checkbox" id="is_continue_0" name="is_continue[]"
                                onchange="prescriptionFunc.setContinueDuration(this)" value="0">
                        </td>
                        {{-- <td class="p-0 px-1 border-0 text-center">
							<input type="checkbox" id="is_chronic_0" name="is_chronic[]" value="0" >
						</td> --}}

                        <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_td_action_0">
                            <span class="btn btn-success btn-sm" id="med_span"
                                data-favourit-action="{{ route('add-pres-favourit-list') }}"
                                data-multidose-action="{{ route('add-multidose') }}"
                                onclick="prescriptionFunc.addMedRow(this)"> <i class="fa fa-plus"></i> </span>

                            {{-- <span class="btn btn-success btn-sm" id="med_span"
                                data-multidose-action="{{route("add-multidose")}}"
                                onclick="prescriptionFunc.addMedRow(this)"> <i class="fa fa-plus"></i> </span> --}}
                        </td>
                    </tr>
                    @if (!empty($pat_med_rs))
                        @php $i=1 @endphp
                        @foreach ($pat_med_rs as $med_row)
                            @if ($med_row->item_no_fk >= 0)
                                <tr class="border-0" id="{{ $i }}">
                                    <td class="p-0 px-1 border-0">
                                        <input type="text"
                                            class="form-control form-control-sm m-0 p-0 item_element bg-white"
                                            id="medicine_item_{{ $i }}" name="medicine_item[]"
                                            placeholder="Generic / Brand" value="{{ $med_row->brand_name }}"
                                            style="border: 0px none;" readonly="readonly">
                                        <input type="hidden" id="hdn_medicine_item_id_{{ $i }}"
                                            name="hdn_medicine_item_id[]" value="{{ $med_row->item_no_fk }}">
                                        <input type="hidden" id="hdn_report_serial_med_{{ $i }}"
                                            name="hdn_report_serial_med[]" value="1">


                                        <input type="hidden" id="hidden_multidose_id_{{ $i }}"
                                            name="multidose[]" value="{{ $med_row->multidose_txt }}">
                                        @if (!empty($med_row->multidose_txt))
                                            <span class="text-secondary mr-1 cursor-pointer"
                                                data-modal="common-modal-xl" style="font-size:11px;"
                                                title="Edit Multidose Medicine"
                                                onclick="prescriptionFunc.addMultidoseList(this)"
                                                data-action="{{ route('add-multidose') }}"
                                                data-id="{{ $med_row->item_no_fk }}"
                                                pres-id="{{ $med_row->prescription_no_pk }}"
                                                data-name="{{ $med_row->brand_name }}" data-type="MED"
                                                data-duration="{{ $med_row->duration }}"
                                                data-route="{{ $med_row->route }}"><input type="hidden"
                                                    id="hidden_multidose_id_{{ $i }}"
                                                    value="{{ $med_row->multidose_txt }}" name="multidose[]"><span
                                                    class="badge bg-secondary text-white">{{ $med_row->multidose_txt }}</span>
                                                <span class="btn btn-danger btn-sm" onclick="removeDose(this)"> <i
                                                        class="fa fa-times"></i> </span></span>
                                        @endif

                                    </td>
                                    <td class="p-0 border-0" id="med_favourit_{{ $i }}"
                                        style="vertical-align: top;"><i class="fa fa-star text-primary"></i></td>
                                    <td class="p-0 px-1 border-0">
                                        <select class="form-control form-control-sm select2 m-0 p-0 medicine_route"
                                            id="medicine_route_{{ $i }}" name="medicine_route[]"
                                            onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');">
                                            <option value="0">Select</option>
                                            @php $external_option_ind = 1; @endphp
                                            @if (!empty($route))
                                                @foreach ($route as $key => $dmu)
                                                    @if ($med_row->route == $key)
                                                        @php $external_option_ind = 0; @endphp
                                                        <option data-qnty="" value="{{ $key }}"
                                                            selected="selected">{{ $dmu['data'] }}</option>
                                                    @else
                                                        <option data-qnty="" value="{{ $key }}">
                                                            {{ $dmu['data'] }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if (!empty($med_row->route) && $external_option_ind == 1)
                                                <option data-qnty="" value="{{ $med_row->route }}"
                                                    selected="selected">{{ $med_row->route }}</option>
                                            @endif
                                            <option data-qnty="0" data-dropdown_option="add_more"
                                                data-popup_header="Medicine Route" data-input_Label="Route"
                                                data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                                value="0">Add More</option>
                                        </select>
                                    </td>
                                    <td class="p-0 px-1 border-0">
                                        <select class="form-control form-control-sm select2 m-0 p-0 medicine_dose"
                                            id="medicine_dose_{{ $i }}" name="medicine_dose[]"
                                            onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose'); prescriptionFunc.calculateMedicineQnty(this);">
                                            <option value="0">Select</option>
                                            @php $external_option_ind = 1; @endphp
                                            @if (!empty($dose))
                                                @foreach ($dose as $key => $dmu)
                                                    @if ($med_row->dosage == $key)
                                                        @php $external_option_ind = 0; @endphp
                                                        <option data-qnty="" value="{{ $key }}"
                                                            selected="selected">{{ $dmu['data'] }}</option>
                                                    @else
                                                        <option data-qnty="" value="{{ $key }}">
                                                            {{ $dmu['data'] }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if (!empty($med_row->dosage) && $external_option_ind == 1)
                                                <option data-qnty="" value="{{ $med_row->dosage }}"
                                                    selected="selected">{{ $med_row->dosage }}</option>
                                            @endif
                                            <option data-qnty="0" data-dropdown_option="add_more"
                                                data-popup_header="Medicine Dose" data-input_Label="Dose"
                                                data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                                value="0">Add More</option>
                                        </select>
                                        {{-- <select class="form-control form-control-sm select2 m-0 p-0 medicine_dose" id="medicine_dose_{{ $i }}" name="medicine_dose[]" onchange="prescriptionFunc.calculateMedicineQnty(this);" >
								<option value="0">Select</option>
								@if (!empty($dose))
								@foreach ($dose as $key => $dmu)
								@if ($med_row->dosage == $key)
								<option data-qnty="" value="{{ $key }}" selected="selected" >{{ $dmu['data'] }}</option>
								@else
								<option data-qnty="" value="{{ $key }}" >{{ $dmu['data'] }}</option>
								@endif
								@endforeach
								@endif
							</select> --}}
                                    </td>

                                    <td class="p-0 px-1 border-0">
                                        <div class="input-group">
                                            {{-- <input type="text" class="form-control form-control-sm m-0 p-0 medicine_duration" id="medicine_duration_type_{{ $i }}" name="medicine_duration_type[]" onkeyup="prescriptionFunc.calculateMedicineQnty(this)" value="{{ $med_row->duration }}" > --}}
                                            <select
                                                class="form-control form-control-sm select2 m-0 p-0 medicine_duration"
                                                id="medicine_duration_type_{{ $i }}"
                                                name="medicine_duration_type[]"
                                                onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_duration'); prescriptionFunc.calculateMedicineQnty(this);">
                                                <option value="0">Select</option>
                                                @php $external_option_ind = 1; @endphp
                                                @if (!empty($duration))
                                                    @foreach ($duration as $key => $dur)
                                                        @if ($med_row->duration == $key)
                                                            @php $external_option_ind = 0; @endphp
                                                            <option data-qnty="" value="{{ $key }}"
                                                                selected="selected">{{ $dur['data'] }}</option>
                                                        @else
                                                            <option data-qnty="" value="{{ $key }}">
                                                                {{ $dur['data'] }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if (!empty($med_row->duration) && $external_option_ind == 1)
                                                    <option data-qnty="" value="{{ $med_row->duration }}"
                                                        selected="selected">{{ $med_row->duration }}</option>
                                                @endif
                                                <option data-qnty="0" data-dropdown_option="add_more"
                                                    data-popup_header="Medicine Duration" data-input_Label="Duration"
                                                    data-input_placeholder="Enter medicine Duration (i.e., 1,2,3...)"
                                                    value="0">Add More</option>
                                            </select>
                                            <select class="form-control medicine_duration_mu"
                                                id="medicine_duration_mu_{{ $i }}"
                                                name="medicine_duration_mu[]"
                                                onchange="prescriptionFunc.calculateMedicineQnty(this)">
                                                @if (!empty($meddurmu))
                                                    @foreach ($meddurmu as $key => $dmu)
                                                        @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                                                            @if ($med_row->duration_mu == strtoupper($key))
                                                                <option value="{{ strtoupper($key) }}"
                                                                    selected="selected">{{ $dmu['data'] }}</option>
                                                            @else
                                                                <option value="{{ strtoupper($key) }}">
                                                                    {{ $dmu['data'] }}</option>
                                                            @endif
                                                        @else
                                                            @if ($med_row->duration_mu == strtoupper($key))
                                                                <option value="{{ strtoupper($key) }}"
                                                                    selected="selected"> দিন</option>
                                                            @else
                                                                <option value="{{ strtoupper($key) }}">
                                                                    @if ($dmu['data'] == 'Day')
                                                                        দিন
                                                                    @elseif($dmu['data'] == 'Hour')
                                                                        ঘন্টা
                                                                    @elseif($dmu['data'] == 'Week')
                                                                        সপ্তাহ
                                                                    @else
                                                                        মাস
                                                                    @endif
                                                                </option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </td>

                                    {{-- <td class="p-0 px-1 border-0">
                                        <input type="text"
                                            class="form-control form-control-sm m-0 p-0 medicine_quantity"
                                            id="medicine_quantity_{{ $i }}" name="medicine_quantity[]"
                                            value="{{ $med_row->item_qty }}">
                                    </td> --}}

                                        <input type="hidden"
                                            class="form-control form-control-sm m-0 p-0 medicine_quantity"
                                            id="medicine_quantity_{{ $i }}" name="medicine_quantity[]"
                                            value="{{ $med_row->item_qty }}">


                                    <td class="p-0 px-1 border-0">
                                        <select
                                            class="form-control form-control-sm select2 m-0 p-0 medicine_instruction"
                                            id="instruction_{{ $i }}" name="instruction[]"
                                            onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');">
                                            <option value="0">Select</option>
                                            @php $external_option_ind = 1; @endphp
                                            @if (!empty($instructions))
                                                @foreach ($instructions as $key => $dmu)
                                                    @if ($med_row->instruction_take == $key)
                                                        @php $external_option_ind = 0; @endphp
                                                        <option value="{{ $key }}" selected="selected">
                                                            {{ $dmu['data'] }}</option>
                                                    @else
                                                        <option value="{{ $key }}">{{ $dmu['data'] }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if (!empty($med_row->instruction_take) && $external_option_ind == 1)
                                                <option data-qnty="" value="{{ $med_row->instruction_take }}"
                                                    selected="selected">{{ $med_row->instruction_take }}</option>
                                            @endif
                                            <option data-qnty="0" data-dropdown_option="add_more"
                                                data-popup_header="Medicine Instruction"
                                                data-input_Label="Instruction"
                                                data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal ...)"
                                                value="0">Add More</option>

                                        </select>
                                    </td>

                                    <td class="p-0 px-1 border-0 text-center">
                                        @if ($med_row->continue_ind == 1)
                                            <input type="checkbox" id="is_continue_{{ $i }}"
                                                name="is_continue[]"
                                                onchange="prescriptionFunc.setContinueDuration(this)"
                                                value="{{ $i }}" checked="checked">
                                        @else
                                            <input type="checkbox" id="is_continue_{{ $i }}"
                                                name="is_continue[]"
                                                onchange="prescriptionFunc.setContinueDuration(this)"
                                                value="{{ $i }}">
                                        @endif
                                    </td>

                                    <td class="p-0 px-1 border-0" style="vertical-align: top;"
                                        id="med_td_action_{{ $i }}">
                                        <span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i
                                                class='fa fa-times'></i> </span>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card-body border-top">
    <div class="form-row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="procedure_item" class="col-form-label col-form-label-sm">Plan</label>
                <input type="text" class="form-control form-control-sm m-0 p-0 item_element mb-0 text-capitalize"
                    id="procedure_item" name="procedure_item"
                    onclick="prescriptionFunc.loadToPresFavouritList(this,'PROCEDURE','Procedure','#proc', '{{ $action_url }}')"
                    data-lookup-id="" data-lookup-code="PROCEDURE">

                <div class="card mt-0">
                    <div class="card-body p-0">
                        @php
                            $class = !empty($pr_arr) ? ' border p-1' : '';
                        @endphp
                        <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="proc">
                            @if (!empty($pr_arr))
                                @foreach ($pr_arr as $rows)
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
                                            <input type="hidden" name="lookup_code[]" value="PROCEDURE"
                                                readonly="readonly">
                                            <input type="hidden" name="lookupdata_code[]"
                                                value="{{ $row_data[3] }}" readonly="readonly">
                                            <i class="fa fa-angle-double-right"></i> {{ $row_data[1] }}&nbsp;&nbsp;
                                            <span class="float-right text-danger cursor-pointer"
                                                title="Remove This Item" onclick="removeParentElement(this)"><i
                                                    class="fa fa-times"></i></span>&nbsp;<span
                                                class="float-right text-secondary mr-1 cursor-pointer"
                                                style="font-size:11px;" title="Add To Favourite List"
                                                onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                data-url="{{ $add_to_pres_url }}" data-id="{{ $row_data[0] }}"
                                                data-name="{{ $row_data[1] }}" data-type="PROCEDURE"><i
                                                    class="fa fa-star text-primary"></i></span>
                                        </li>
                                    @endforeach
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            {{-- <div class="form-group">
                <label for="procedure_item" class="col-form-label col-form-label-sm">Plan</label>
                <input type="text" class="form-control form-control-sm m-0 p-0 item_element mb-0 text-capitalize"
                    id="procedure_item" name="procedure_item" data-append-id="proc" lookup-code="PROCDURE"
                    onclick="prescriptionFunc.loadToPresFavouritList(this,'SERVICE,SUR','Procedure','#proc', '{{ $action_url }}')"
                    data-lookup-id="" data-lookup-code="SERVICE">

                <div class="card mt-0">
                    <div class="card-body p-0">
                        @php
                            $class = !empty($pr_arr) ? ' border p-1' : '';
                        @endphp
                        <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="proc">
                            @if (!empty($pr_arr))
                                @foreach ($pr_arr as $rows)
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
                                            <input type="hidden" name="lookup_code[]" value="PROCEDURE"
                                                readonly="readonly">
                                            <input type="hidden" name="lookupdata_code[]"
                                                value="{{ $row_data[3] }}" readonly="readonly">
                                            <i class="fa fa-angle-double-right"></i> {{ $row_data[1] }}&nbsp;&nbsp;
                                            <span class="float-right text-danger cursor-pointer"
                                                title="Remove This Item" onclick="removeParentElement(this)"><i
                                                    class="fa fa-times"></i></span>&nbsp;<span
                                                class="float-right text-secondary mr-1 cursor-pointer"
                                                style="font-size:11px;" title="Add To Favourite List"
                                                onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                data-url="{{ $add_to_pres_url }}" data-id="{{ $row_data[0] }}"
                                                data-name="{{ $row_data[1] }}" data-type="PROCEDURE"><i
                                                    class="fa fa-star text-primary"></i></span>
                                        </li>
                                    @endforeach
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="disposal_item" class="col-form-label col-form-label-sm">Disposal</label>
                <input type="text" class="form-control form-control-sm m-0 p-0 item_element mb-0  text-capitalize"
                    id="disposal_item" name="disposal_item"
                    onclick="prescriptionFunc.loadToPresFavouritList(this,'DISPOSAL','Disposal','#disposal', '{{ $action_url }}')"
                    data-lookup-id="" data-lookup-code="DISPOSAL">

                <div class="card mt-0">
                    <div class="card-body p-0">
                        @php
                            $class = !empty($dis_arr) ? ' border p-1' : '';
                        @endphp
                        <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="disposal">
                            @if (!empty($dis_arr))
                                @foreach ($dis_arr as $rows)
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
                                            <input type="hidden" name="lookup_code[]" value="DISPOSAL"
                                                readonly="readonly">
                                            <input type="hidden" name="lookupdata_code[]"
                                                value="{{ $row_data[3] }}" readonly="readonly">
                                            <i class="fa fa-angle-double-right"></i> {{ $row_data[1] }}&nbsp;&nbsp;
                                            <span class="float-right text-danger cursor-pointer"
                                                title="Remove This Item" onclick="removeParentElement(this)"><i
                                                    class="fa fa-times"></i></span>&nbsp;<span
                                                class="float-right text-secondary mr-1 cursor-pointer"
                                                style="font-size:11px;" title="Add To Favourite List"
                                                onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                data-url="{{ $add_to_pres_url }}" data-id="{{ $row_data[0] }}"
                                                data-name="{{ $row_data[1] }}" data-type="DISPOSAL"><i
                                                    class="fa fa-star text-primary"></i></span>
                                        </li>
                                    @endforeach
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="cmb_advice" class="col-form-label col-form-label-sm">Advice</label>
                <input type="text" class="form-control mb-0" id="advice" name="advice"
                    placeholder="Enter Advice"
                    onclick="prescriptionFunc.loadToPresFavouritList(this,'ADVICE','Advice','#adv', '{{ $action_url }}')"
                    data-lookup-id="" data-lookup-code="ADVICE">

                <div class="card mt-0">
                    <div class="card-body p-0">
                        @php
                            $class = !empty($ad_arr) ? ' border p-1' : '';
                        @endphp
                        <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="adv">
                            @if (!empty($ad_arr))
                                @foreach ($ad_arr as $rows)
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
                                            <input type="hidden" name="lookup_code[]" value="ADVICE"
                                                readonly="readonly">
                                            <input type="hidden" name="lookupdata_code[]"
                                                value="{{ $row_data[3] }}" readonly="readonly">
                                            <i class="fa fa-angle-double-right"></i> {{ $row_data[1] }}&nbsp;&nbsp;
                                            <span class="float-right text-danger cursor-pointer"
                                                title="Remove This Item" onclick="removeParentElement(this)"><i
                                                    class="fa fa-times"></i></span>&nbsp;
                                            @if ($row_data[0] != 0)
                                                <span class="float-right text-secondary mr-1 cursor-pointer"
                                                    style="font-size:11px;" title="Add To Favourite List"
                                                    onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                    data-url="{{ $add_to_pres_url }}"
                                                    data-id="{{ $row_data[0] }}" data-name="{{ $row_data[1] }}"
                                                    data-type="ADVICE"><i class="fa fa-star text-primary"></i></span>
                                            @endif
                                        </li>
                                    @endforeach
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="followup_after" class="col-form-label col-form-label-sm">Followup After</label>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm m-0 p-0 number_only"
                        id="followup_after" name="followup_after"
                        onkeyup="prescriptionFunc.calculateFollowupDate(this)"
                        value="{{ isset($followup_num) ? $followup_num : '' }}">
                    <select class="form-control" id="followup_after_mu" name="followup_after_mu"
                        onchange="prescriptionFunc.calculateFollowupDate(this)">
                        <option value="0">Select</option>
                        @if (!empty($followup_mu))
                            @foreach ($followup_mu as $key => $fmu)
                                @if ($followup_mu_name == '')
                                    @if (strtoupper($key) == 'DAY')
                                        <option value="{{ strtoupper($key) }}" selected="selected">
                                            {{ $fmu['data'] }}</option>
                                    @else
                                        <option value="{{ strtoupper($key) }}">{{ $fmu['data'] }}</option>
                                    @endif
                                @else
                                    @if (strtoupper($key) == $followup_mu_name)
                                        <option value="{{ strtoupper($key) }}" selected="selected">
                                            {{ $fmu['data'] }}</option>
                                    @else
                                        <option value="{{ strtoupper($key) }}">{{ $fmu['data'] }}</option>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="next_followup" class="col-form-label col-form-label-sm">Next Followup</label>
                <input type="text" class="form-control date_picker_app" name="next_followup" id="next_followup"
                    value="{{ isset($next_followup_dt) ? date('d-m-Y', strtotime($next_followup_dt)) : '' }}">
                {{-- {{ isset($next_followup_dt) ? date('d/m/Y', strtotime($next_followup_dt)) : '' }} --}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="txt_referred_doctor" class="col-form-label col-form-label-sm">Referred Doctor /
                    Hospital</label>
                <input type="text" class="form-control " name="txt_referred_doctor" id="txt_referred_doctor"
                    placeholder="Write Referred Doctor Name"
                    value="{{ isset($pat_med_rs[0]->ref_doc_name) ? $pat_med_rs[0]->ref_doc_name : '' }}">

                <input type="hidden" name="ref_doc_card_hidn" id="ref_doc_card_hidn"
                    value="{{ isset($pat_med_rs[0]->ref_doctor) ? $pat_med_rs[0]->ref_doctor : '' }}">
            </div>
        </div>
        @if (Session::get('user.ses_hospital_code') != 'IMPALA')
            <div class="col-md-12">
                <div class="form-group">
                    <label for="txt_rx_note" class="col-form-label col-form-label-sm">Note</label>
                    <textarea class="form-control  text-capitalize" name="txt_rx_note" id="txt_rx_note" rows="1">{{ isset($presc_note) ? $presc_note : '' }}</textarea>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="form-group">
                    <label for="txt_rx_note" class="col-form-label col-form-label-sm text-capitalize">Note</label>
                    @if (isset($presc_note))
                        @if ($presc_note != '')
                            @php
                                $presc_note = explode('^', $presc_note);
                            @endphp
                        @endif
                    @endif
                    <textarea class="form-control " name="txt_rx_note" id="txt_rx_note" rows="1">{{ isset($presc_note) ? $presc_note[0] : '' }}</textarea>
                </div>
            </div>
        @endif

            @if (Session::get('user.ses_hospital_code') != 'IMPALA')
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="expected_session" class="col-form-label col-form-label-sm">Expected
                            session</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm m-0 p-0 number_only"
                                id="expected_session" name="expected_session" onkeyup="" value="">
                            <select class="form-control" id="expected_session_mu" name="expected_session_mu"
                                onchange="">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                </div>
            @endif
        @if (Session::get('user.ses_hospital_code') != 'IMPALA')
            <div class="col-md-12">
                <div class="form-group">
                    <label for="template_name" class="col-form-label col-form-label-sm">
                        Template Name <span class="text-danger" id="template_msg"></span>
                    </label>
                    <input type="text"
                        class="form-control form-control-sm m-0 p-0 item_element mb-0"
                        id="template_name" name="template_name" value="">
                </div>
            </div>
        @endif
    </div>
</div>



<!-- Multi Dose Modal -->
<div class="modal fade" id="multiDose" role="dialog" aria-labelledby="multiDoseTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Multi Dose</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card bg-light-blue mt-0">
                    <div class="card-body p-2">
                        <div class="form-row">
                            <span><b>Generic:</b> TAB PARAYROL 500 MG, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Brand:</b> Squre
                                Pharmaciticals, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Route:</b> ORAL</span>
                        </div>
                    </div>
                </div>

                <div class="card bg-light-blue">
                    <div class="card-body p-2">
                        <table class="table border-0 mt-2 mb-0">
                            <thead>
                                <tr class="">
                                    <th class="border-0">Dose </th>
                                    <th class="border-0">Duration</th>
                                    <th class="border-0">Qty.</th>
                                    <th class="border-0">Instruction</th>
                                    <th class="border-0"></th>
                                </tr>
                            </thead>

                            <tbody>
                                <td class="p-0 px-1 border-0">
                                    <select class="form-control form-control-sm  m-0 p-0" id=""
                                        name="">
                                        <option value="0">Select</option>
                                        <option value="0">1+1+1</option>
                                        <option value="0">1+0+1</option>
                                        <option value="0">0+0+1</option>
                                        <option value="0">1+1+0</option>
                                        <option value="0">1+0+0</option>
                                    </select>
                                </td>

                                <td class="p-0 px-1 border-0">
                                    <select class="form-control m-0 p-0 " id="" name="">
                                        <option value="0">Select</option>
                                    </select>
                                </td>

                                <td class="p-0 px-1 border-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm m-0 p-0  "
                                            id="" name="">
                                        <select class="form-control" id="" name="">
                                            <option value="0">Select</option>
                                        </select>
                                    </div>
                                </td>

                                <td class="p-0 px-1 border-0">
                                    <select class="form-control form-control-sm select2 m-0 p-0" id="instruction_0"
                                        name="instruction[]">
                                        <option value="0">Select</option>
                                    </select>
                                </td>
                                <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_td_action_0">
                                    <span class="btn btn-success btn-sm"> <i class="fa fa-plus"></i> </span>
                                </td>
                            </tbody>
                        </table>


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txt_multi_dose_rx_note"
                                        class="col-form-label col-form-label-sm">Note</label>
                                    <textarea class="form-control" name="txt_multi_dose_rx_note" id="txt_multi_dose_rx_note" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-1">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary"> Add Doses</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Dose Option Modal -->
<div class="modal fade" id="addMoreDropdownOption" tabindex="-1" role="dialog"
    aria-labelledby="addMoreDropdownOptionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="newDropdownOptionDiv">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="addMoreDropdownOptionHeader">Header</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('prescription-lookup.storeprescriptionlookupitemdoctor') }}" method="post"
                id="prescription-create">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="new_dose_opt" id="addMoreDropdownOptionLabel"
                                class="col-form-label col-form-label-sm">Label</label>
                            <input type="hidden" name="thisElement_id" id="thisElement_id" value="">
                            <input type="text" class="form-control" id="new_dropdown_opt" name="new_dropdown_opt"
                                value="" placeholder="Enter new option" required>
                        </div>

                    </div>
                </div>
                <div class="modal-footer py-1">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary add_new_option_btn"
                            onclick="prescriptionFunc.addToDropdown(this)">Add</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    function removeDose(params) {
        $(params).parents('span').remove();
    }
    // $('.select2').select2();
</script>
