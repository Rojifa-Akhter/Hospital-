<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<div class="card-body border-top">
    <h4>R<sub>x</sub></h4>
    <div class="row">
        <div class="col-md-12">
            <table class="table border-0 mt-2 mb-0">
                <thead>
                    <tr class="border-0">
                        <th class="p-0 border-0 w-35" colspan="3">Medicine <a
                                class="btn btn-sm btn-outline-primary open-modal" data-modal="common-modal-md"
                                data-action="{{ route('prescription-most-used-medicine') }}"
                                data-title="Most Used Medicine">MUM</a>
                        </th>

                        <th class="p-0 px-1 border-0 w-12">Dose</th>
                        <th class="p-0 px-1 border-0 w-8" hidden>Qty.</th>
                        <th class="p-0 px-1 border-0 w-12">Route</th>
                        <th class="p-0 px-1 border-0">Instruction</th>
                        <th class="p-0 px-1 border-0 w-20">Duration</th>
                        <th class="p-0 px-1 border-0">Continue</th>
                        {{-- <th class="p-0 px-1 border-0">Chronic</th> --}}
                        <th class="p-0 px-1 border-0"></th>
                    </tr>
                </thead>
                <tbody id="data-append-to">
                    <tr class="border-0" id="0">
                        <td class="p-0 border-0" style="width: 25%;">
                            <input type="text"
                                class="form-control form-control-sm m-0 p-0 item_element text-capitalize"
                                id="medicine_item_0" name="medicine_item[]" placeholder="Generic / Brand"
                                onclick="prescriptionFunc.loadToPresFavouritList(this,'MED','Medicine','#data-append-to', '{{ $action_url }}')">

                            <input type="hidden" id="hdn_medicine_item_id_0" name="hdn_medicine_item_id[]">
                            <input type="hidden" id="hdn_report_serial_med_0" name="hdn_report_serial_med[]"
                                value="1">
                            {{-- <input type="hidden" id="hdn_medicine_item_id" name="hdn_medicine_item_id_[]"
                                value=""> --}}

                            <input type="hidden" id="hidden_multidose_id_0" value="" name="multidose[]">
                        </td>
                        <td class="p-0 border-0" id="alternative_id_0" style="vertical-align: top;"></td>
                        <td class="p-0 border-0" id="med_favourit_0" style="vertical-align: top;"></td>


                        <td class="p-0 px-1 border-0">
                            <div class="input-group" id="doseID">
                                <select class="form-control m-0 p-0 medicine_dose doseEdit" id="medicine_dose_0"
                                    name="medicine_dose[]"
                                    onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose');prescriptionFunc.calculateMedicineQnty(this)">
                                    <option value="0">Select</option>
                                    <option data-qnty="0" data-dropdown_option="add_more"
                                        data-popup_header="Medicine Dose" data-input_label="Dose"
                                        data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                        value="0">Add More</option>
                                    @if (!empty($dose))
                                        @foreach ($dose as $key => $dmu)
                                            <option value="{{ $key }}">{{ $dmu['data'] }}</option>
                                        @endforeach
                                    @endif

                                </select>
                                <div class="editDosButton" id="medicine_dose_0" style="display:none;"
                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editDosButton');"
                                    data-qnty="0" data-dropdown_option_edit="edit_option_dose"
                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                    data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                    value="0">
                                    <span class="btn btn-success btn-sm" type="button"
                                        style="padding: 5px 5px 6px 5px !important"> <i class="fa fa-edit"></i></span>
                                </div>
                            </div>
                        </td>
                        {{-- <option value="0">Select</option> --}}

                        <td class="p-0 px-1 border-0" hidden> {{-- hidden for ewmch requ --}}
                            <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity"
                                id="medicine_quantity_0" name="medicine_quantity[]">
                        </td>

                        <td class="p-0 px-1 border-0">
                            <div class="input-group" id="routeId">
                                <select class="form-control form-control-sm m-0 p-0 medicine_route route_edit"
                                    id="medicine_route_0" name="medicine_route[]"
                                    onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');">
                                    <option value="0">Select</option>
                                    <option data-qnty="0" data-dropdown_option="add_more"
                                        data-popup_header="Medicine Route" data-input_label="Route"
                                        data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                        value="0">
                                        Add
                                        More</option>

                                    @if (!empty($route))
                                        @foreach ($route as $key => $dmu)
                                            <option value="{{ $key }}">{{ $dmu['data'] }}</option>
                                        @endforeach
                                    @endif

                                </select>
                                <div class="editRouteValue" id="medicine_route_0" style="display:none;"
                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editRouteValue');"
                                    data-qnty="0" data-dropdown_option_edit="edit_option_route"
                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">
                                    <span class="btn btn-success btn-sm" type="button"
                                        style="padding: 5px 5px 6px 5px !important"> <i class="fa fa-edit"></i></span>
                                </div>
                            </div>
                        </td>

                        <td class="p-0 px-1 border-0" style="width: 15%;">
                            <div class="input-group" id="instructionId">
                                <select
                                    class="form-control form-control-sm m-0 p-0 medicine_instruction instructionEdit"
                                    id="instruction_0" name="instruction[]"
                                    onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');">

                                    <option value="0">Select</option>
                                    <option data-qnty="0" data-dropdown_option="add_more"
                                        data-popup_header="Medicine Instruction" data-input_label="Instruction"
                                        data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal..)"
                                        value="0">Add More</option>
                                    @if (!empty($instructions))
                                        @foreach ($instructions as $key => $dmu)
                                            <option value="{{ $key }}">{{ $dmu['data'] }}</option>
                                        @endforeach
                                    @endif

                                </select>
                                <div class="editInsButton" id="instruction_0" style="display:none;"
                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editInsButton');"
                                    data-qnty="0" data-dropdown_option_edit="edit_option"
                                    data-popup_header="Medicine Instruction" data-input_label="Instruction"
                                    data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal..)"
                                    value="0">
                                    <span class="btn btn-success btn-sm" type="button"
                                        style="padding: 5px 5px 6px 5px !important"> <i class="fa fa-edit"></i></span>
                                </div>
                            </div>

                            {{-- @endif

                            @if (Session::get('user.ses_hospital_code') == 'EWMCH')

                                <div class="card mt-0">
                                    <div class="card-body p-0">
                                        @php
                                            $class = !empty($ad_arr) ? ' border p-1' : '';
                                        @endphp
                                        <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="ins">
                                            @if (!empty($ad_arr))
                                                @foreach ($ad_arr as $rows)
                                                    @foreach ($rows as $row)
                                                        @php
                                                            $row_data = explode('_', $row);
                                                        @endphp
                                                        <li id="item-{{ $row_data[0] }}">
                                                            <input type="hidden" name="item_id[]"
                                                                value="{{ $row_data[0] }}" readonly="readonly">
                                                            <input class="left-element" type="hidden"
                                                                name="item_name[]" value="{{ $row_data[1] }}"
                                                                readonly="readonly">
                                                            <input type="hidden" name="lookup_id[]"
                                                                value="{{ $row_data[2] }}" readonly="readonly">
                                                            <input type="hidden" name="lookup_code[]" value="ADVICE"
                                                                readonly="readonly">
                                                            <input type="hidden" name="lookupdata_code[]"
                                                                value="{{ $row_data[3] }}" readonly="readonly">
                                                            <i class="fa fa-angle-double-right"></i>
                                                            {{ $row_data[1] }}
                                                        </li>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endif --}}

                        </td>


                        <td class="p-0 px-1 border-0">
                            <div class="input-group" id="durationId">
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
                                                @if (Session::get('user.ses_hospital_code') != 'AMCSH')
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
                                                            @elseif($dmu['data'] == 'Month')
                                                                মাস
                                                            @else
                                                                চলবে
                                                            @endif
                                                        </option>
                                                    @endif
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
                                                        @elseif($dmu['data'] == 'Month')
                                                            মাস
                                                        @elseif($dmu['data'] == 'Continue')
                                                            চলবে
                                                        @endif
                                                    </option>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif

                                </select>
                            </div>
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
                                data-alternative-action="{{ route('alternative-medicine') }}"
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
                                <tr class="border-0" id="tr_id_{{ $i }}">
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

                                    <td class="p-0 border-0" id="alternative_id_{{ $i }}"
                                        style="vertical-align: top;">
                                        <span class="float-right text-secondary cursor-pointer"
                                            data-modal="common-modal-sm"
                                            style="font-size:11px;border: 1px solid aqua;padding: 4px;margin-top: 9px;border-radius: 5px;"
                                            title="Alternative Medicine"
                                            onclick="prescriptionFunc.alternativeMedicine(this)"
                                            data-url="{{ route('add-pres-favourit-list') }}"
                                            data-id="{{ $med_row->item_no_fk }}"
                                            data-name="{{ $med_row->brand_name }}" data-type="MED"
                                            data-duration="{{ $med_row->duration }}"
                                            data-route="{{ $med_row->route }}" data-dose="{{ $med_row->dosage }}"
                                            data-quantity="{{ $med_row->item_qty }} data-continue="{{ $med_row->continue_ind }}"
                                            data-instruction="{{ $med_row->instruction_take }}"
                                            data-duration-type="{{ $med_row->instruction_take }}"
                                            data-alternative-action="{{ route('alternative-medicine') }}">ALT</span>
                                    </td>
                                    <td class="p-0 border-0" id="med_favourit_{{ $i }}"
                                        style="vertical-align: top;">
                                        <span class="float-right text-secondary mr-1 cursor-pointer"
                                            style="font-size:11px;" title="Add To Favourite List"
                                            onclick="prescriptionFunc.addToPresFavouritList(this)"
                                            data-url="{{ route('add-pres-favourit-list') }}"
                                            data-id="{{ $med_row->item_no_fk }}"
                                            data-name="{{ $med_row->brand_name }}" data-type="MED"
                                            data-duration="{{ $med_row->duration }}"
                                            data-route="{{ $med_row->route }}" data-dose="{{ $med_row->dosage }}"
                                            data-quantity="{{ $med_row->item_qty }} data-continue="{{ $med_row->continue_ind }}"
                                            data-instruction="{{ $med_row->instruction_take }}"
                                            data-duration-type="{{ $med_row->instruction_take }}"><i
                                                class="fa fa-star text-primary"></i></span> <br /> <span
                                            class="float-right text-secondary mr-1 cursor-pointer"
                                            data-modal="common-modal-xl" style="font-size:11px;"
                                            title="Add Multidose Medicine"
                                            onclick="prescriptionFunc.addMultidoseList(this)"
                                            data-action="{{ route('add-multidose') }}"
                                            data-url="{{ route('add-pres-favourit-list') }}"
                                            data-id="{{ $med_row->item_no_fk }}"
                                            data-name="{{ $med_row->brand_name }}" data-type="MED"
                                            data-duration="{{ $med_row->duration }}"
                                            data-route="{{ $med_row->route }}" data-dose="{{ $med_row->dosage }}"
                                            data-quantity="{{ $med_row->item_qty }} data-continue="{{ $med_row->continue_ind }}"
                                            data-instruction="{{ $med_row->instruction_take }}"
                                            data-duration-type="{{ $med_row->instruction_take }}"
                                            data-row-id="{{ $i }}"><i
                                                class="fa fa-medkit text-danger"></i></span>

                                        {{-- <i class="fa fa-star text-primary"> </i> --}}

                                    </td>

                                    <td class="p-0 px-1 border-0">

                                        <select class="form-control form-control-sm m-0 p-0 medicine_dose"
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
                                        <select class="form-control form-control-sm m-0 p-0 medicine_route"
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


                                    <td class="p-0 px-1 border-0" hidden>
                                        <input type="text"
                                            class="form-control form-control-sm m-0 p-0 medicine_quantity"
                                            id="medicine_quantity_{{ $i }}" name="medicine_quantity[]"
                                            value="{{ $med_row->item_qty }}">
                                    </td>

                                    <td class="p-0 px-1 border-0">
                                        <select class="form-control form-control-sm m-0 p-0 medicine_instruction"
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
                                    <td class="p-0 px-1 border-0">
                                        <div class="input-group">
                                            {{-- <input type="text" class="form-control form-control-sm m-0 p-0 medicine_duration" id="medicine_duration_type_{{ $i }}" name="medicine_duration_type[]" onkeyup="prescriptionFunc.calculateMedicineQnty(this)" value="{{ $med_row->duration }}" > --}}
                                            <select class="form-control form-control-sm m-0 p-0 medicine_duration"
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
                                                                    @elseif($dmu['data'] == 'Month')
                                                                        মাস
                                                                    @elseif($dmu['data'] == 'Continue')
                                                                        চলবে
                                                                    @endif
                                                                </option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
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
                <input type="text" class="form-control form-control-sm m-0 p-0 item_element mb-0"
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
                <label for="disposal_item" class="col-form-label col-form-label-sm">
                    @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                        Intervention <span class="text-danger">*</span>
                    @else
                        Disposal
                    @endif
                </label>
                {{-- <input type="text" class="form-control form-control-sm m-0 p-0 item_element mb-0  text-capitalize"
                    id="disposal_item" name="disposal_item"
                    onclick="prescriptionFunc.loadToPresFavouritList(this,'DISPOSAL','Disposal','#disposal', '{{ $action_url }}')"
                    data-lookup-id="{{ @$lookup_id_arr->DISPOSAL }}" data-lookup-code="DISPOSAL"> --}}
                {{-- <div class="card mt-0">
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



                </div> --}}



                <select name="disposal_item_ewmch" id="disposal_item_ewmch" class="form-control">
                    @if (!empty($intervention))
                        @foreach ($intervention as $data)
                            <option value="{{ $data->pres_lookupdata_name }}">{{ $data->pres_lookupdata_name }}
                            </option>
                        @endforeach

                    @endif

                </select>

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="cmb_advice" class="col-form-label col-form-label-sm">Advice <a
                        class="btn btn-sm btn-outline-primary open-modal" data-modal="common-modal-md"
                        data-action="{{ route('prescription-most-used-items', 'ADVICE') }}"
                        data-title="Most Used Advice" data-append-id="#adv"
                        onclick="prescriptionFunc.mosUsedIdPass(this)">MUA</a></label>
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

                                        <li id="item-">
                                            <input type="hidden" name="item_id[]" value=""
                                                readonly="readonly">
                                            <input class="left-element" type="hidden" name="item_name[]"
                                                value="" readonly="readonly">
                                            <input type="hidden" name="lookup_id[]" value=""
                                                readonly="readonly">
                                            <input type="hidden" name="lookup_code[]" value="ADVICE"
                                                readonly="readonly">
                                            <input type="hidden" name="lookupdata_code[]"
                                                value="" readonly="readonly">
                                            <i class="fa fa-angle-double-right"></i> &nbsp;&nbsp;
                                            <span class="float-right text-danger cursor-pointer"
                                                title="Remove This Item" onclick="removeParentElement(this)"><i
                                                    class="fa fa-times"></i></span>&nbsp;
                                                <span class="float-right text-secondary mr-1 cursor-pointer"
                                                    style="font-size:11px;" title="Add To Favourite List"
                                                    onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                    data-url=""
                                                    data-id="" data-name=""
                                                    data-type="ADVICE"><i class="fa fa-star text-primary"></i></span>
                                        </li>
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
                        value="">
                    <select class="form-control" id="followup_after_mu" name="followup_after_mu"
                        onchange="prescriptionFunc.calculateFollowupDate(this)">
                        <option value="0">Select</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="next_followup" class="col-form-label col-form-label-sm">Next Followup</label>
                <input type="text" class="form-control date_picker_app" name="next_followup" id="next_followup"
                    value="">
            </div>
        </div>
        <div class="col-md-4">
            <label for="txt_referred_doctor" class="col-form-label col-form-label-sm">Referred Doctor /
                Hospital  <a
                class="btn btn-sm btn-outline-primary open-modal" data-modal="common-modal-md"
                data-action="{{ route('prescription-most-used-refered-doctor') }}"
                data-title="Most Used Refered Doctor">MUD</a></label>
            <div class="form-row">
                <div class="col-md-6">
                    <input type="text" class="form-control " name="txt_referred_doctor" id="txt_referred_doctor"
                        placeholder="Write Referred Doctor Name"
                        value="">
                    <input type="hidden" name="ref_doc_card_hidn" id="ref_doc_card_hidn"
                        value="">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control department_name" name="department" id="department"
                        placeholder="Department" value="" disabled>

                </div>
            </div>
        </div>


        @if (Session::get('user.ses_hospital_code') != 'IMPALA')
            <div class="col-md-12">
                <div class="form-group">
                    <label for="txt_rx_note" class="col-form-label col-form-label-sm text-capitalize">Note</label>
                    <textarea class="form-control" name="txt_rx_note" id="txt_rx_note" rows="1">{{ isset($presc_note) ? $presc_note : '' }}</textarea>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="form-group">
                    <label for="txt_rx_note" class="col-form-label col-form-label-sm text-capitalize">Note</label>
                
                    <textarea class="form-control" name="txt_rx_note" id="txt_rx_note" rows="1">{{ isset($presc_note) ? $presc_note[0] : '' }}</textarea>
                </div>
            </div>
        @endif

            @if (Session::get('user.ses_hospital_code') != 'IMPALA')
                @if (Session::get('user.ses_hospital_code') != 'AMCSH')
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
                                    <select class="form-control form-control-sm m-0 p-0" id="instruction_0"
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

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.instructionEdit').change(function() {
        let instruction = $('.instructionEdit').val();
        if (instruction != '0') {
            $('.editInsButton').show();
        }
    });

    $('.doseEdit').change(function() {

        let dose = $('.doseEdit').val();

        if (dose != '0') {
            console.log(dose)
            $('.editDosButton').show();
        }
    });

    $('.route_edit').change(function() {

        let dose = $('.route_edit').val();

        if (dose != '0') {
            console.log(dose)
            $('.editRouteValue').show();
        }
    });

    function removeDose(params) {
        $(params).parents('span').remove();
    }
    // $('.select2').select2();
    // for Department
    function dept(item, obj) {
        console.log(item.su_name)
        console.log(item.su_name)
        $(".department_name").val(item.su_name)
    }
</script>
