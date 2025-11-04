<style>
    .discharge_note .redactor_.redactor_editor {
        height: 100px !important;
    }

</style>

<?php
$pre_ot_date = $admission_details->pre_ot_date ? date('d-m-Y', strtotime($admission_details->pre_ot_date)) : '';
$pre_ot_time = $admission_details->pre_ot_time ? date('h:i a', strtotime($admission_details->pre_ot_time)) : '';
$post_ot_date = $admission_details->post_ot_date ? date('d-m-Y', strtotime($admission_details->post_ot_date)) : '';
$post_ot_time = $admission_details->post_ot_time ? date('h:i a', strtotime($admission_details->post_ot_time)) : '';
$first_baby_birthdate = $admission_details->first_baby_birthdate ? date('d-m-Y', strtotime($admission_details->first_baby_birthdate)) : '';
$first_baby_time = $admission_details->first_baby_time ? date('h:i a', strtotime($admission_details->first_baby_time)) : '';
$second_baby_birthdate = $admission_details->second_baby_birthdate ? date('d-m-Y', strtotime($admission_details->second_baby_birthdate)) : '';
$second_baby_time = $admission_details->second_baby_time ? date('h:i a', strtotime($admission_details->second_baby_time)) : '';
?>
<div class="" id=" summary_data">
    <div class="card">
        <div class="card-body">
            <div class="form-row border-bottom mt-3 pb-3">
                <div class="col-md-6">

                    <div class="card-body p-2 inv_with_finding">
                        <label for="inv_with_finding" class="col-form-label col-form-label-sm">Investigations with finding: </label>
                        <textarea id="inv_with_finding" style="height: 150px!important;"
                        name="inv_with_finding"
                        class="form-control form-control-sm">{{ $admission_details->inv_with_finding ?? ''}}</textarea>
                    </div>
                    
                    {{-- <table class="table border-0 m-0">
                        <thead>
                            <tr class="border-0">
                                <th class="p-0 px-1 border-0 w-25">Investigation</th>
                                <th class="p-0 px-1 border-0">Investigation Findings</th>
                                <th class="p-0 px-1 border-0">Note</th>
                                <th class="p-0 px-1 border-0"></th>
                            </tr>
                        </thead>
                        <tbody id="data-append">
                            <tr class="border-0" id="1">
                                <td class="p-0 px-1 border-0">
                                    <input class='hdn_investigation_id' id='hdn_investigation_id_1' type='hidden'
                                        name='hdn_investigation_id[]' value=''>
                                    <input class='hdn_item_name' type='hidden' name='hdn_investigation_name[]'
                                        id='hdn_investigation_name_1' value=''>
                                    <input class='hdn_item_type' type='hidden' id='hdn_investigation_type_1'
                                        name='hdn_investigation_type[]' value=''>

                                    <input type="text"
                                        class="form-control item_investigation_typehead form-control-sm m-0"
                                        id="investigation_1" name="investigation[]" value=""
                                        placeholder="Enter Investigation Name">
                                </td>
                                <td class="p-0 px-1 border-0">
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="investigation_findings_1" name="investigation_findings[]" value=""
                                        placeholder="Write Investigation Findings">
                                </td>
                                <td class="p-0 px-1 border-0">
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="investigation_note_1" name="investigation_note[]" value=""
                                        placeholder="Write Investigation Note">
                                </td>
                                <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_fin_td_action_1">
                                    <span class="btn btn-success btn-sm" onclick="addRowForInvestigation(this)"> <i
                                            class="fa fa-plus"></i> </span>
                                </td>
                            </tr>

                        <tfoot id="data-append">
                            @php
                                $key = 2;
                            @endphp

                            @if (!empty($dis_investigation_info))
                                @foreach ($dis_investigation_info as $row)
                                    <tr class="border-0" id="{{ $key }}">
                                        <td class="p-0 px-1 border-0">
                                            <input class='hdn_investigation_id'
                                                id='hdn_investigation_id_{{ $key }}' type='hidden'
                                                name='hdn_investigation_id[]' value='{{ $row->item_no_fk }}'>
                                            <input class='hdn_item_name' type='hidden' name='hdn_investigation_name[]'
                                                id='hdn_investigation_name_{{ $key }}'
                                                value='{{ $row->investigation_name }}'>
                                            <input class='hdn_item_type' type='hidden'
                                                id='hdn_investigation_type_{{ $key }}'
                                                name='hdn_investigation_type[]' value=''>

                                            <input type="text"
                                                class="form-control item_investigation_typehead form-control-sm m-0"
                                                id="investigation_{{ $key }}" name="investigation[]"
                                                value="{{ $row->investigation_name }}"
                                                placeholder="Enter Investigation Name">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control form-control-sm m-0"
                                                id="investigation_findings_{{ $key }}"
                                                name="investigation_findings[]" value="{{ $row->findings_text }}"
                                                placeholder="Write Investigation Findings">
                                        </td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control form-control-sm m-0"
                                                id="investigation_note_{{ $key }}" name="investigation_note[]"
                                                value="{{ $row->investigation_note }}"
                                                placeholder="Write Investigation Note">
                                        </td>
                                        <td class="p-0 px-1 border-0" style="vertical-align: top;"
                                            id="med_fin_td_action_{{ $key }}">
                                            <span class="btn btn-danger btn-sm" onclick="removeTableRowOnly(this)">
                                                <i class="fa fa-times"></i>
                                            </span>
                                        </td>
                                    </tr>
                                    @php
                                        $key++;
                                    @endphp

                                @endforeach
                            @endif
                        </tfoot>


                        </tbody>
                    </table> --}}

                </div>
                <div class="col-md-6">
                    <div class="card-body p-2 inv_with_finding">
                        <label for="discharge_advice" class="col-form-label col-form-label-sm">Advice On Discharge: </label>
                        <textarea id="discharge_advice" style="height: 150px!important;"
                        name="discharge_advice"
                        class="form-control form-control-sm">{{ $admission_details->discharge_advice ?? ''}}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <table class="table border-0 m-0">
                        <thead>
                            <tr class="border-0">
                                <th class="p-0 px-1 border-0 w-25">Generic / Brand</th>
                                <th class="p-0 px-1 border-0">Route</th>
                                <th class="p-0 px-1 border-0">Dose</th>
                                <th class="p-0 px-1 border-0">Duration</th>
                                {{-- <th class="p-0 px-1 border-0">Quantity</th> --}}
                                <th class="p-0 px-1 border-0">Instruction</th>
                                <th class="p-0 px-1 border-0">Continue</th>
                                <th class="p-0 px-1 border-0"></th>
                            </tr>
                        </thead>
                        <tbody id="data-append-to">
                            <tr class="border-0" id="1">
                                <td class="p-0 px-1 border-0">
                                    <input class='item_id' id='hdn_item_id_1' type='hidden' name='hdn_item_id[]'
                                        value=''>
                                    <input class='hdn_item_name' type='hidden' id='hdn_item_name_1'
                                        name='hdn_item_name[]' value=''>
                                    <input class='hdn_item_type' type='hidden' id='hdn_item_type_1'
                                        name='hdn_item_type[]' value=''>

                                    <input type="text"
                                        class="form-control item_typehead form-control-sm m-0 p-0 item_element"
                                        id="medicine_item_1" value="" name="medicine_item[]" onkeyup="setItemInfoForFreeHand(this)" placeholder="Generic / Brand">
                                </td>

                                {{-- route --}}
                                <td class="p-0 px-1 border-0"> 
                                    <select class="form-control form-control-sm select2 m-0 p-0 medicine_route" 
                                        id="medicine_route_1" name="medicine_route[]" 
                                        onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');"> 
                                        <option value="0">Select</option> 
                                        <option data-qnty="0" data-dropdown_option="add_more"
                                            data-popup_header="Medicine Route"
                                            data-input_label="Route"
                                            data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                            value="0">Add More</option> 
                                        @if(!empty($route)) 
                                            @foreach ($route as $key => $dmu) 
                                                <option value="{{ $key }}">
                                                    {{ is_array($dmu) && isset($dmu['data']) ? $dmu['data'] : $dmu }}
                                                </option>
                                            @endforeach 
                                        @endif 
                                    </select> 
                                </td>

                                <td class="p-0 px-1 border-0">
                                    <select class="form-control form-control-sm select2 m-0 p-0 medicine_dose"
                                        id="medicine_dose_1" name="medicine_dose[]"
                                        onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose');prescriptionFunc.calculateMedicineQnty(this);">
                                        <option value="0">Select</option>
                                        <option data-qnty="0" data-dropdown_option="add_more"
                                        data-popup_header="Medicine Dose" data-input_label="Dose"
                                        data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                        value="0">Add More</option>
                                        @if (!empty($dose))
                                            @foreach ($dose as $key => $value)
                                                <option data-qnty="" value="{{ $value }}">{{ $value }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </td>

                                <td class="p-0 px-1 border-0 w-20">
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control form-control-sm m-0 p-0 medicine_duration"
                                        id="medicine_duration_type_1" name="medicine_duration_type[]"
                                        onkeyup="prescriptionFunc.calculateMedicineQnty(this)">
                                    <select class="form-control medicine_duration_mu" id="medicine_duration_mu_1"
                                        name="medicine_duration_mu[]"
                                        onchange="prescriptionFunc.calculateMedicineQnty(this)">
                                        <option value="0">Select</option>
                                        @php
                                            $durationOptions = ['DAY', 'WEEK', 'MONTH'];
                                        @endphp
                                        @foreach ($durationOptions as $option)
                                            <option value="{{ $option }}">{{ ucfirst(strtolower($option)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>


                                {{-- <td class="p-0 px-1 border-0 w-10">
                                    <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity"
                                        id="medicine_quantity_1" name="medicine_quantity[]">
                                </td> --}}

                                <td class="p-0 px-1 border-0">
                                    {{-- <select class="form-control form-control-sm select2 m-0 p-0" id="instruction_1"
                                        name="instruction[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');">
                                        <option value="0">Select</option>
                                        <option data-qnty="0" data-dropdown_option="add_more"
                                            data-popup_header="Medicine Instruction" data-input_label="Instruction"
                                            data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal..)"
                                            value="0">Add More
                                        </option> --}}
                                        <select
                                        class="form-control form-control-sm m-0 p-0 medicine_instruction select2"
                                        id="instruction_1" name="instruction[]"
                                        onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');">
                                            <option value="0">Select</option>
                                            <option data-qnty="0" data-dropdown_option="add_more"
                                                data-popup_header="Medicine Instruction" data-input_label="Instruction"
                                                data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal..)"
                                                value="0">Add More</option>
                                            @if (!empty($instructions))
                                                @foreach ($instructions as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            @endif

                                    </select>
                                </td>

                                <td class="p-0 px-1 border-0">
                                    <input type="checkbox" id="is_continue_1" name="is_continue[]" value="1">
                                </td>

                                <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_td_action_1">
                                    <span class="btn btn-success btn-sm" onclick="addRow(this)"> <i
                                            class="fa fa-plus"></i> </span>
                                </td>
                            </tr>
                        <tfoot id="data-append-to">
                            @php
                                $counter = 2;
                            @endphp
                            @if (!empty($dis_med_info))
                                @foreach ($dis_med_info as $row)
                                    <tr class="border-0" id="{{ $counter }}">
                                        <td class="p-0 px-1 border-0">
                                            <input class='item_id' id='hdn_item_id_{{ $counter }}' type='hidden'
                                                name='hdn_item_id[]' value='{{ $row->item_no_fk }}'>
                                            <input class='hdn_item_name' type='hidden'
                                                id='hdn_item_name_{{ $counter }}' name='hdn_item_name[]'
                                                value='{{ $row->item_name }}'>
                                            <input class='hdn_item_type' type='hidden'
                                                id='hdn_item_type_{{ $counter }}' name='hdn_item_type[]' value=''>

                                            <input type="text"
                                                class="form-control item_typehead form-control-sm m-0 p-0 item_element"
                                                id="medicine_item_{{ $counter }}" name="medicine_item[]"
                                                value="{{ $row->item_name }}" placeholder="Generic / Brand">
                                        </td>
                                        {{-- route --}}
                                        {{-- @php
                                            dd($dmu);
                                        @endphp --}}
                                        <td class="p-0 px-1 border-0">
                                            <select class="form-control form-control-sm select2 m-0 p-0 medicine_route"
                                                id="medicine_route_{{ $counter }}" name="medicine_route[]"
                                                onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');">
                                                <option value="0">Select</option>
                                                <option data-qnty="0" data-dropdown_option="add_more"
                                                    data-popup_header="Medicine Route" data-input_label="Route"
                                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                                    value="0">Add More
                                                </option>
                                                @if(!empty($route))
                                                    @foreach ($route as $key => $dmu)
                                                        <option value="{{ $key }}" {{ $key == $row->route ? 'selected' : '' }}>
                                                            {{ is_array($dmu) && isset($dmu['data']) ? $dmu['data'] : $dmu }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                                @if (!empty($row->route) && !array_key_exists($row->route, $route))
                                                    <option value="{{ $row->route }}" selected>
                                                        {{ $row->route }}
                                                    </option>
                                                @endif
                                            </select>
                                        </td>

                                        <td class="p-0 px-1 border-0">
                                            <select class="form-control form-control-sm select2 m-0 p-0 medicine_dose"
                                                id="medicine_dose_{{ $counter }}" name="medicine_dose[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose'); prescriptionFunc.calculateMedicineQnty(this);">
                                                <option value="0">Select</option>
                                                <option data-qnty="0" data-dropdown_option="add_more"
                                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                                    data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                                    value="0">Add More
                                                </option>
                                                @if (!empty($dose))
                                                    @foreach ($dose as $key => $value)
                                                        <option value="{{ $value }}"
                                                            {{ $value == $row->dosage ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>

                                        <td class="p-0 px-1 border-0 w-20">
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 p-0 medicine_duration"
                                                    id="medicine_duration_type_{{ $counter }}"
                                                    name="medicine_duration_type[]" value="{{ $row->duration }}">
                                                <select class="form-control medicine_duration_mu"
                                                    id="medicine_duration_mu_{{ $counter }}"
                                                    name="medicine_duration_mu[]">
                                                <option value="0">Select</option>
                                                @php
                                                    $durationOptions = ['DAY','WEEK','MONTH'];
                                                @endphp
                                                @foreach ($durationOptions as $option)
                                                    <option value="{{ $option }}" 
                                                        {{ (isset($row) && strtoupper($row->duration_mu) == $option) ? 'selected' : '' }}>
                                                        {{ ucfirst(strtolower($option)) }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            </div>
                                        </td>

                                        {{-- <td class="p-0 px-1 border-0 w-10">
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 medicine_quantity"
                                                id="medicine_quantity_{{ $counter }}" name="medicine_quantity[]"
                                                value=" {{ $row->item_qty ? $row->item_qty : '' }}">
                                        </td> --}}

                                        <td class="p-0 px-1 border-0">
                                            <select class="form-control form-control-sm select2 m-0 p-0 medicine_instruction"
                                                id="instruction_{{ $counter }}" name="instruction[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');">
                                                <option value="0">Select</option>
                                                <option data-qnty="0" data-dropdown_option="add_more"
                                                    data-popup_header="Medicine Instruction" data-input_label="Instruction"
                                                    data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal..)"
                                                    value="0">Add More
                                                </option>
                                                @if (!empty($instructions))
                                                    @foreach ($instructions as $key => $val)
                                                        <option value="{{ $key }}"
                                                            {{ $key == $row->med_taken_instruction ? 'selected' : '' }}>
                                                            {{ $val }}
                                                        </option>
                                                    @endforeach
                                                @endif

                                                @if (!empty($row->med_taken_instruction) && !array_key_exists($row->med_taken_instruction, $instructions))
                                                    <option value="{{ $row->med_taken_instruction }}" selected>
                                                        {{ $row->med_taken_instruction }}
                                                    </option>
                                                @endif

                                            </select>
                                        </td>

                                        <td class="p-0 px-1 border-0">
                                            <input type="checkbox" id="is_continue_{{ $counter }}" value="1"
                                                name="is_continue_{{ $row->item_no_fk }}[]"
                                                {{ $row->continue_ind == 1 ? 'checked' : '' }}>
                                        </td>

                                        <td class="p-0 px-1 border-0" style="vertical-align: top;"
                                            id="med_td_action_{{ $counter }}">
                                            <span class="btn btn-danger btn-sm" onclick="removeTableRowOnly(this)">
                                                <i class="fa fa-times"></i> </span>
                                        </td>
                                    </tr>
                                    @php
                                        $counter++;
                                    @endphp
                                @endforeach
                            @endif
                        </tfoot>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        {{-- <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    &nbsp;
                    <h5>Discharge Note</h5>
                </div>
                <div class="card-body p-2 discharge_note">
                    <textarea id="discharge_note"
                        name="discharge_note">{{ $admission_details->discharge_summary_note }}</textarea>
                </div>
            </div>
        </div> --}}

        

    </div>

    <div class="form-row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <h5>OT Note</h5>
                </div>
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Ot date</label>
                            <input type="text" class="form-control form-control-sm m-0 date_picker" name="pre_ot_date"
                                placeholder="dd-mm-yy" value="{{ $pre_ot_date }}">

                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Ot Time</label>
                            <input type="text" class="form-control form-control-sm m-0 timepicker" name="pre_ot_time"
                                placeholder="time" value="{{ $pre_ot_time }}">

                        </div>

                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Name of Operation</label>
                            <input type="text" class="form-control form-control-sm m-0" name="pre_ot_operation"
                                placeholder="" value="{{ $admission_details->pre_ot_operation }}">
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pre_ot_indication" class="col-form-label col-form-label-sm">Ot Indication</label>
                                <textarea id="pre_ot_indication" name="pre_ot_indication" class="form-control form-control-sm m-0" rows="3" style="white-space: nowrap; overflow-x: auto;">{{ $admission_details->pre_ot_indication }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pre_ot_precedure" class="col-form-label col-form-label-sm">Ot procedure</label>
                                <textarea id="pre_ot_precedure" name="pre_ot_precedure" class="form-control form-control-sm m-0" rows="3" style="white-space: nowrap; overflow-x: auto;">{{ $admission_details->pre_ot_precedure }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Ot Anaesthesia</label>
                            <input type="text" class="form-control form-control-sm m-0" name="" placeholder=""
                                id="pre_ot_anaesthesia" value="{{ $pre_ot_anaesthesia_no }}">
                            <input type="hidden" name="pre_ot_anaesthesia" id="hdn_pre_ot_anaesthesia"
                                value="{{ $admission_details->pre_ot_anaesthesia_no }}">
                        </div>

                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Ot Surgeon</label>
                            <input type="text" class="form-control form-control-sm m-0" name="" placeholder=""
                                id="pre_ot_surgeon" value="{{ $pre_ot_surgeon_no }}">
                            <input type="hidden" name="pre_ot_surgeon" id="hdn_pre_ot_surgeon"
                                value="{{ $admission_details->pre_ot_surgeon_no }}">
                        </div>

                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Ot Assistant</label>
                            <input type="text" class="form-control form-control-sm m-0" name="" placeholder=""
                                id="pre_ot_assis" value="{{ $admission_details->full_name ?? '' }}">
                            <input type="hidden" name="pre_ot_assis" id="hdn_pre_ot_assis"
                                value="{{ $admission_details->pre_ot_assis_no }}">
                        </div>

                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Ot Anaesthetist</label>
                            <input type="text" class="form-control form-control-sm m-0" id="pre_ot_anaesthetist"
                                placeholder="" value="{{ $pre_ot_anaesthetist_no }}">
                            <input type="hidden" name="pre_ot_anaesthetist" id="hdn_pre_ot_anaesthetist"
                                value="{{ $admission_details->pre_ot_anaesthetist_no }}">
                        </div>

                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Pre Operation Finding</label>
                            <input type="text" class="form-control form-control-sm m-0" name="pre_ot_note"
                                placeholder="" value="{{ $admission_details->pre_ot_note }}">
                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Complication</label>
                            <input type="text" class="form-control form-control-sm m-0" name="pre_ot_complication"
                                placeholder="" value="{{ $admission_details->pre_ot_complication }}">
                        </div>
                    </div>

                    {{-- <textarea id="pre_ot" name="pre_ot">{{ $admission_details->pre_ot_note }}</textarea> --}}
                </div>
            </div>
        </div>

        {{-- <div class="col-md-6">
            <div class="card">
                <div class="card-header">

                    <h5>Post-OT Note</h5>
                </div>
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Post ot date</label>
                            <input type="text" class="form-control form-control-sm m-0 date_picker" name="post_ot_date"
                                placeholder="dd-mm-yy" value="{{ $post_ot_date }}">

                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Post ot Time</label>
                            <input type="text" class="form-control form-control-sm m-0 timepicker" name="post_ot_time"
                                placeholder="time" value="{{ $post_ot_time }}">

                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Post ot operation</label>
                            <input type="text" class="form-control form-control-sm m-0" name="post_ot_operation"
                                placeholder="" value="{{ $admission_details->post_ot_operation }}">
                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Post ot indication</label>
                            <input type="text" class="form-control form-control-sm m-0" name="post_ot_indication"
                                placeholder="" value="{{ $admission_details->post_ot_indication }}">
                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Post ot anaesthesia</label>
                            <input type="text" class="form-control form-control-sm m-0" id="post_ot_anaesthesia"
                                name ="post_ot_anaesthesia" placeholder="" value="{{ $post_ot_anaesthesia_no }}">
                            <input type="hidden" name="post_ot_anaesthesia" id="hdn_post_ot_anaesthesia"
                                value="{{ $admission_details->post_ot_anaesthesia_no }}">
                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Post ot surgeon</label>
                            <input type="text" class="form-control form-control-sm m-0" id="post_ot_surgeon"
                                placeholder="" value="{{ $post_ot_surgeon_no }}">
                            <input type="hidden" name="post_ot_surgeon" id="hdn_post_ot_surgeon"
                                value="{{ $admission_details->post_ot_surgeon_no }}">
                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Post ot anaesthetist</label>
                            <input type="text" class="form-control form-control-sm m-0" id="post_ot_anaesthetist"
                                placeholder="" value="{{ $post_ot_anaesthetist_no }}">
                            <input type="hidden" name="post_ot_anaesthetist" id="hdn_post_ot_anaesthetist"
                                value="{{ $admission_details->post_ot_anaesthetist_no }}">
                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">Post ot precedure</label>
                            <input type="text" class="form-control form-control-sm m-0" name="post_ot_precedure"
                                placeholder="" value="{{ $admission_details->post_ot_precedure }}">
                        </div>
                    </div>
                    <textarea id="post_ot" name="post_ot">{{ $admission_details->post_ot_note }}</textarea>
                </div>
            </div>
        </div> --}}

       <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Procedure Note</h5>
                </div>
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-md-12">
                            <textarea class="form-control form-control-sm m-0"
                                name="procedure_note"
                                style="height: 150px!important;">{{ $admission_details->procedure_note }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">

        </div>
        <div class="col-md-6">
            <div class="card">
               <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0 me-2">Baby Note</h5>
                    <div class="form-check m-0 mb-4">
                        <input type="checkbox" class="form-check-input" id="toggle_baby_note">
                    </div>
                </div>

                <div class="card-body" id="baby_note_section" style="display:none;">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Date of Delivery</label>
                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                name="first_baby_birth_date" placeholder="dd-mm-yy"
                                value="{{ $first_baby_birthdate }}">
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Time of Delivery</label>
                            <input type="text" class="form-control form-control-sm m-0 timepicker"
                                name="first_baby_time" placeholder="time" value="{{ $first_baby_time }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Delivery Mode</label>
                            <input type="text" class="form-control form-control-sm m-0" name="first_baby_delivery_mode"
                                value="{{ $admission_details->first_baby_delivery_mode }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Presentation</label>
                            <input type="text" class="form-control form-control-sm m-0" name="first_baby_presentation"
                                value="{{ $admission_details->first_baby_presentation }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Gestational Age</label>
                            <input type="text" class="form-control form-control-sm m-0" name="first_baby_gestational_age"
                                value="{{ $admission_details->first_baby_gestational_age }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">APGAR</label>
                            <input type="text" class="form-control form-control-sm m-0" name="first_baby_apgar"
                                value="{{ $admission_details->first_baby_apgar }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Resuscitation</label>
                            <input type="text" class="form-control form-control-sm m-0" name="first_baby_resuscitation"
                                value="{{ $admission_details->first_baby_resuscitation }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Gender</label>
                            <select class="form-control form-control-sm select2 m-0 p-0"
                                name="first_baby_gender">
                                <option value="">Select</option>
                                @if (!empty($gender))
                                    @foreach ($gender as $key => $value)
                                        <option value="{{ $key }}" @if ($key == $admission_details->first_baby_gender_no) selected @endif>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Weight</label>
                            <input type="text" class="form-control form-control-sm m-0" name="first_baby_wt"
                                value="{{ $admission_details->first_baby_wt }}">
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Length</label>
                            <input type="text" class="form-control form-control-sm m-0" name="first_baby_length"
                                value="{{ $admission_details->first_baby_length }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">OFC</label>
                            <input type="text" class="form-control form-control-sm m-0" name="first_baby_ofc"
                                value="{{ $admission_details->first_baby_ofc }}">
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-12 ">
                            <div class="d-flex align-items-center mb-3">
                                <h5 class="mb-0 me-3">No Other Apparent Congenital Anomalies</h5>
                                <input type="text" class="form-control form-control-sm m-0" 
                                    name="congenital_anomalies"
                                    value="{{ $admission_details->congenital_anomalies }}"
                                    style="width: 30%; margin-left: 15px!important;">
                            </div>

                            <h5 class="mb-3"><u>Maternal History:</u></h5>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Age</label>
                            <input type="text" class="form-control form-control-sm m-0" name="mother_age"
                                value="{{ $admission_details->mother_age }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Gravida</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_gravida"
                                value="{{ $admission_details->maternal_gravida }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Para</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_para"
                                value="{{ $admission_details->maternal_para }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Antenatal Care</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_antenatal_care"
                                value="{{ $admission_details->maternal_antenatal_care }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Mother's Blood Group</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_blood_group"
                                value="{{ $admission_details->maternal_blood_group }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">VDRL</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_vdrl_result"
                                value="{{ $admission_details->maternal_vdrl_result }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">HBSAg</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_hbsag_result"
                                value="{{ $admission_details->maternal_hbsag_result }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Consanguinity</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_consanguinity"
                                value="{{ $admission_details->maternal_consanguinity }}">
                        </div>
                    </div>

                    {{-- <textarea id="first_baby_note" name="first_baby_note">{{ $admission_details->first_baby_note }}</textarea> --}}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
               <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0 me-2">2nd Baby Note</h5>
                    <div class="form-check m-0 mb-4">
                        <input type="checkbox" class="form-check-input" id="toggle_baby_note1">
                    </div>
                </div>

                <div class="card-body" id="baby_note_section1" style="display:none;">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Date of Delivery</label>
                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                name="second_baby_birthdate" placeholder="dd-mm-yy"
                                value="{{ $second_baby_birthdate }}">
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Time of Delivery</label>
                            <input type="text" class="form-control form-control-sm m-0 timepicker"
                                name="second_baby_time" placeholder="time" value="{{ $second_baby_time }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Delivery Mode</label>
                            <input type="text" class="form-control form-control-sm m-0" name="second_baby_delivery_mode"
                                value="{{ $admission_details->second_baby_delivery_mode }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Presentation</label>
                            <input type="text" class="form-control form-control-sm m-0" name="second_baby_presentation"
                                value="{{ $admission_details->second_baby_presentation }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Gestational Age</label>
                            <input type="text" class="form-control form-control-sm m-0" name="second_baby_gestational_age"
                                value="{{ $admission_details->second_baby_gestational_age }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">APGAR</label>
                            <input type="text" class="form-control form-control-sm m-0" name="second_baby_apgar"
                                value="{{ $admission_details->second_baby_apgar }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Resuscitation</label>
                            <input type="text" class="form-control form-control-sm m-0" name="second_baby_resuscitation"
                                value="{{ $admission_details->second_baby_resuscitation }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Gender</label>
                            <select class="form-control form-control-sm select2 m-0 p-0"
                                name="second_baby_gender">
                                <option value="">Select</option>
                                @if (!empty($gender))
                                    @foreach ($gender as $key => $value)
                                        <option value="{{ $key }}" @if ($key == $admission_details->second_baby_gender_no) selected @endif>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Weight</label>
                            <input type="text" class="form-control form-control-sm m-0" name="second_baby_wt"
                                value="{{ $admission_details->second_baby_wt }}">
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Length</label>
                            <input type="text" class="form-control form-control-sm m-0" name="second_baby_length"
                                value="{{ $admission_details->second_baby_length }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">OFC</label>
                            <input type="text" class="form-control form-control-sm m-0" name="second_baby_ofc"
                                value="{{ $admission_details->second_baby_ofc }}">
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-12 ">
                            <h5 class="mb-3">No Other Apparent Congenital Anomalies</h5>
                            <h5 class="mb-3"><u>Maternal History:</u></h5>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Age</label>
                            <input type="text" class="form-control form-control-sm m-0" name="mother_age2"
                                value="{{ $admission_details->mother_age }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Gravida</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_gravida2"
                                value="{{ $admission_details->maternal_gravida }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Para</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_para2"
                                value="{{ $admission_details->maternal_para }}">
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Antenatal Care</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_antenatal_care2"
                                value="{{ $admission_details->maternal_antenatal_care }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Mother's Blood Group</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_blood_group2"
                                value="{{ $admission_details->maternal_blood_group }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">VDRL</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_vdrl_result2"
                                value="{{ $admission_details->maternal_vdrl_result }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">HBSAg</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_hbsag_result2"
                                value="{{ $admission_details->maternal_hbsag_result }}">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm">Consanguinity</label>
                            <input type="text" class="form-control form-control-sm m-0" name="maternal_consanguinity2"
                                value="{{ $admission_details->maternal_consanguinity }}">
                        </div>
                    </div>

                    {{-- <textarea id="first_baby_note" name="first_baby_note">{{ $admission_details->first_baby_note }}</textarea> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h5>Case Summary </h5> --}}
                </div>
                <div class="row ml-1 mr-1">
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">CC</label>
                        <textarea class="form-control form-control-sm m-0" 
                            name="cc" style="height: 150px!important;"
                            placeholder=""
                            rows="3">{{ isset($admission_details->cc_text) ? $admission_details->cc_text : '' }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">O/E ON ADMISSION</label>
                        <textarea class="form-control form-control-sm m-0" 
                            name="on_admission" style="height: 150px!important;"
                            placeholder=""
                            rows="3">{{ isset($admission_details->oe_admission) ? $admission_details->oe_admission : '' }}</textarea>
                    </div>
                    <div class="col-md-4">
                         <label for="" class="col-form-label col-form-label-sm">O/E ON DISCHARGE / Treatment</label> {{--O/E ON DISCHARGE --}}
                        <textarea class="form-control form-control-sm m-0" 
                            name="on_discharge" style="height: 150px!important;"
                            placeholder="Treatment"
                            rows="3">{{ isset($admission_details->oe_discharge) ? $admission_details->oe_discharge : '' }}</textarea>
                    </div>
                </div>

                <div class="row ml-1 mr-1">
                    {{-- Case Summary Remarks --}}
                    <div class="card-body p-2 case_summary_remarks">
                        <label for="case_summary_remarks" class="col-form-label col-form-label-sm">Case Summary :</label>
                        <textarea id="case_summary_remarks" name="case_summary_remarks"
                        class="form-control form-control-sm">{{ $admission_details->case_summary_remarks ?? ''}}</textarea>
                    </div>

                    <div class="card-body p-2 course_in_hospital">
                        <label for="course_in_hospital" class="col-form-label col-form-label-sm">Course in Hospital: </label>
                        <textarea id="course_in_hospital"
                        name="course_in_hospital" style="height: 150px!important;"
                        class="form-control form-control-sm">{{ $admission_details->course_in_hospital ?? ''}}</textarea>

                    </div>

                </div>

                <div class="row ml-1 mr-1">
                    <div class="card-body p-2 adm_form_past_med_hist">
                        <label for="adm_form_past_med_hist" class="col-form-label col-form-label-sm">Patient Past Clinical History: </label>
                        <textarea id="adm_form_past_med_hist"
                        name="adm_form_past_med_hist" style="height: 150px!important;"
                        class="form-control form-control-sm">{{ $admission_details->adm_form_past_med_hist ?? '' }}</textarea>

                    </div>
                    <div class="card-body p-2 pat_current_cli_history">
                        <label for="pat_current_cli_history" class="col-form-label col-form-label-sm">Patient Current Clinical History: </label>
                        <textarea id="pat_current_cli_history"
                        name="pat_current_cli_history" style="height: 150px!important;"
                        class="form-control form-control-sm">{{ $admission_details->pat_current_cli_history ?? ''}}</textarea>

                    </div>
                </div>
                <div class="row ml-1 mr-1">
                    <div class="card-body p-2 clinical_examination">
                        <label for="clinical_examination" class="col-form-label col-form-label-sm">Clinical Examination: </label>
                        <textarea id="clinical_examination"
                        name="clinical_examination" style="height: 150px!important;"
                        class="form-control form-control-sm">{{ $admission_details->clinical_examination ?? '' }}</textarea>

                    </div>
                    <div class="card-body p-2 local_examination">
                        <label for="local_examination" class="col-form-label col-form-label-sm">Local Examination: </label>
                        <textarea id="local_examination"
                        name="local_examination" style="height: 150px!important;"
                        class="form-control form-control-sm">{{ $admission_details->local_examination ?? ''}}</textarea>
                    </div>
                </div>


                <div class="row ml-1 mr-1">
                    {{-- Treatment During Hospitalization --}}
                    <div class="card-body p-2 treatment_during_hospitalization">
                        <label for="treatment_during_hospitalization" class="col-form-label col-form-label-sm">Treatment During Hospitalization</label>
                        <textarea class="form-control form-control-sm m-0" 
                            name="treatment_during_hospitalization" style="height: 150px!important;"
                            placeholder="Treatment During Hospitalization"
                            rows="3">{{ isset($admission_details->treatment_during_hospital) ? $admission_details->treatment_during_hospital : '' }}</textarea>
                    </div>
                    {{-- Conservative Treatment --}}
                    <div class="card-body p-2 when_how_obtn_urgnt_care">
                        <label for="when_how_obtn_urgnt_care" class="col-form-label col-form-label-sm">When & how to obtain urgent care</label>
                        <textarea class="form-control form-control-sm m-0" 
                            name="when_how_obtn_urgnt_care" style="height: 150px!important;"
                            placeholder="When & how to obtain urgent care"
                            rows="3">{{ isset($admission_details->when_how_obtn_urgnt_care) ? $admission_details->when_how_obtn_urgnt_care : '' }}</textarea>
                    </div>
                </div>
                <div class="row ml-1 mr-1">
                    {{-- Special Note --}}
                    <div class="card-body p-2 special_note">
                        <label for="special_note" class="col-form-label col-form-label-sm">Special Note</label>
                        <textarea class="form-control form-control-sm m-0" 
                            name="special_note" style="height: 150px!important;"
                            placeholder="Special Note"
                            rows="3">{{ isset($admission_details->special_note) ? $admission_details->special_note : '' }}</textarea>
                    </div>
                    {{-- Other Note --}}
                    <div class="card-body p-2 other_note">
                        <label for="other_note" class="col-form-label col-form-label-sm">Other Note</label>
                        <textarea class="form-control form-control-sm m-0" 
                            name="other_note" style="height: 150px!important;"
                            placeholder="Other Note"
                            rows="3">{{ isset($admission_details->other_note) ? $admission_details->other_note : '' }}</textarea>
                    </div>
                </div>
                <div class="row ml-1 mr-1">
                    {{-- <div class="card-body p-2 discharge_advice">
                        <label for="discharge_advice" class="col-form-label col-form-label-sm">Advice on discharge:</label>
                        <input type="text" class="form-control form-control-sm m-0" name="discharge_advice" placeholder="discharge advice"
                            value="{{ isset($admission_details->discharge_advice) ? $admission_details->discharge_advice : '' }}"
                        />
                    </div> --}}
                    <div class="card-body p-2 discharge_plan">
                        <label for="discharge_plan" class="col-form-label col-form-label-sm">Plan on discharge:</label>
                        <textarea class="form-control form-control-sm m-0" 
                            name="discharge_plan" style="height: 150px!important;"
                            placeholder="Discharge Plan"
                            rows="3">{{ isset($admission_details->discharge_plan) ? $admission_details->discharge_plan : '' }}</textarea>
                    </div>

                    {{-- Emergency Contact Information: --}}
                    <div class="card-body p-2 contact_person">
                        <label for="contact_person" class="col-form-label col-form-label-sm">Emergency Contact Information:</label>
                        <input type="text" class="form-control form-control-sm m-0" name="contact_person" placeholder="Emergency Contact Information"
                            value="Contact Unico Hospital Emergency Department @ +8809677667766" readonly
                            />
                    </div>
                    <div class="card-body p-2 followup_date">
                        <label for="followup_date" class="col-form-label col-form-label-sm">
                            Discharge Follow Up Visit Date:
                        </label>
                        <input type="date"
                        class="form-control form-control-sm m-0"
                        name="followup_date"
                        value="{{ isset($admission_details->followup_date) ? \Carbon\Carbon::parse($admission_details->followup_date)->format('Y-m-d') : '' }}"
                        min="{{ date('Y-m-d') }}">

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<script>

    function setItemInfoForFreeHand(element) {

        let itemName=$(element).val();
            console.log(itemName)
        $('#hdn_item_id_1').val(0);
        $('#hdn_item_name_1').val(itemName);
        $('#hdn_item_type_1').val(0);
    }

    $(document).ready(function () {
        $('#toggle_baby_note').change(function () {
            if ($(this).is(':checked')) {
                $('#baby_note_section').slideDown();
            } else {
                $('#baby_note_section').slideUp();
            }
        });
    });
    $(document).ready(function () {
        $('#toggle_baby_note1').change(function () {
            if ($(this).is(':checked')) {
                $('#baby_note_section1').slideDown();
            } else {
                $('#baby_note_section1').slideUp();
            }
        });
    });

    

</script>



