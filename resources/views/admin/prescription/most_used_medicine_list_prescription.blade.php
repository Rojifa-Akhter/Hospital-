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

                                    </td>

                                    <td class="p-0 px-1 border-0">
                                        <select
                                            class="form-control form-control-sm m-0 p-0 medicine_instruction"
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
                                            <select
                                                class="form-control form-control-sm m-0 p-0 medicine_duration"
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
                                        {{-- @if ($med_row->continue_ind == 1)
                                            <input type="checkbox" id="is_continue_{{ $i }}"
                                                name="is_continue[]"
                                                onchange="prescriptionFunc.setContinueDuration(this)"
                                                value="{{ $i }}" checked="checked">
                                        @else
                                            <input type="checkbox" id="is_continue_{{ $i }}"
                                                name="is_continue[]"
                                                onchange="prescriptionFunc.setContinueDuration(this)"
                                                value="{{ $i }}">
                                        @endif --}}
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
