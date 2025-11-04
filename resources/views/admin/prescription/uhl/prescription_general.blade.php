<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    /* select.form-control {
    min-height: 0px !important;
} */
    .select2-container .select2-dropdown {
        width: 400px !important;
        /* Specify the desired width here */
    }

    .select2-selection__rendered {
        text-align: left !important;
    }

    .select2-results__option {
        font-size: 12px !important;
    }

    .prescription-table>thead>tr>th {
        font-size: 12px !important;
        white-space: nowrap;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        overflow-x: hidden;
        width: 230px;
    }

    /* CSS for readonly button */
    .readonly-btn {
        cursor: not-allowed;
        /* Change the cursor to not-allowed */
        background-color: rgb(204, 204, 204);
        /* Light gray background */
        pointer-events: none;
        /* Prevent click events */
    }

    /* Hide the selection text */


    [id^="medicine_dose_"]+.select2-container .select2-selection--single .select2-selection__rendered {
        width: 90px;
        overflow-x: hidden;
    }

    /* Hide the clear button */
    [id^="medicine_dose_"]+.select2-container .select2-selection--single .select2-selection__clear {
        width: 90px;
        overflow-x: hidden;
    }

    [id^="medicine_route_"]+.select2-container .select2-selection--single .select2-selection__rendered {
        width: 90px;
        overflow-x: hidden;
    }

    /* Hide the clear button */
    [id^="medicine_route_"]+.select2-container .select2-selection--single .select2-selection__clear {
        width: 90px;
        overflow-x: hidden;
    }

    [id^="instruction_"]+.select2-container .select2-selection--single .select2-selection__rendered {
        width: 380px;
        overflow-x: hidden;
    }

    /* Hide the clear button */
    [id^="instruction_"]+.select2-container .select2-selection--single .select2-selection__clear {
        width: 380px;
        overflow-x: hidden;
    }
</style>
<div class="card-body border-top">


    <?php
    // Check if $pat_pres_list is not empty
    if (!empty($pat_pres_list)) {
        // Extract the first value
        $first_value = reset($pat_pres_list);
        $firstKey = array_key_first($pat_pres_list);

        // Split the string by underscores
        $parts = explode('_', $first_value);

        // Extract the desired values
        $first_number = $parts[1]; // 1779
        $second_number = $parts[2]; // 1361
        $specific_value = $parts[5]; // 2025543
    }
    ?>

    <h4>R<sub>x</sub>
        @isset($first_value)
        <sub>
            @if ($date_app[9] == session('user.ses_person_no_fk'))
            {{-- Latest Prescription --}}
            <span class="btn btn-outline-info btn-md bg-none cursor-pointer"
                data-presc="" data-presc-type="pre"
                data-dtls-action="{{ route('get-prescription-medicine-dtls-uhl', [$firstKey, $specific_value]) }}"
                data-action="{{ route('get-prescription-mst', [$first_number, $second_number]) }}"
                onclick="medicationUpdate(this)" title="Edit Medicine Only" data-temp="TEMP">
                Global Prescription
            </span>

            {{-- Last Prescription --}}
            <span class="btn btn-outline-secondary btn-md bg-none cursor-pointer ms-2"
                data-presc="" data-presc-type="last"
                data-dtls-action="{{ route('get-last-prescription-medicine-dtls-uhl', [$firstKey, $specific_value]) }}"
                data-action="{{ route('get-prescription-mst', [$first_number, $second_number]) }}"
                onclick="medicationUpdateLast(this)" title="View Last Prescription" data-temp="TEMP">
                Last Prescription
            </span>
            @endif
        </sub>
        @endisset
    </h4>





    <div class="row">
        <div class="col-md-12">
            <table class="table border-0 mt-2 mb-0">
                <thead>
                    <tr class="border-0">
                        <th class="p-0 border-0 w-35" colspan="3">Medicine
                            <a class="btn btn-sm btn-outline-primary open-modal" data-modal="common-modal-md"
                                data-action="{{ route('prescription-most-used-medicine-uhl') }}"
                                data-title="Most Used Medicine">MUM</a>
                        </th>
                        {{-- <th class="p-0 px-1 border-0 w-12">Dose</th> --}}
                        <th class="p-0 px-1 border-0">Frequency</th>
                        <th class="p-0 px-1 border-0" hidden>Qty.</th>
                        <th class="p-0 px-1 border-0">Route</th>
                        <th class="p-0 px-1 border-0">Instruction</th>
                        <th class="p-0 px-1 border-0">Duration</th>
                        <th class="p-0 px-1 border-0">Continue</th>
                        {{-- <th class="p-0 px-1 border-0">Chronic</th> --}}
                        <th class="p-0 px-1 border-0"></th>
                    </tr>
                </thead>
                <tbody id="data-append-to">
                    <tr class="border-0" id="0">
                        <td class="p-0 border-0" style="width: 70% !important;">
                            {{-- text-capitalize --}}
                            <input type="text" class="form-control form-control-sm m-0 p-0 item_element"
                                id="medicine_item_0" name="medicine_item[]" placeholder="Generic / Brand"
                                onclick="prescriptionV2.loadToPresFavouritListV2(this,'MED','Medicine','#data-append-to', '{{ $action_url }}','#pres-favourit-list-med')" />

                            <input type="hidden" id="hdn_medicine_item_id_0" name="hdn_medicine_item_id[]" />
                            <input type="hidden" id="hdn_genetic_id_0" name="hdn_genetic_id[]" value="">
                            <input type="hidden" id="hdn_report_serial_med_0" name="hdn_report_serial_med[]"
                                value="1" />
                            <input type="hidden" id="hidden_multidose_id_0" value="" name="multidose[]" />
                        </td>
                        <td class="p-0 border-0" id="alternative_id_0" style="vertical-align: top;"></td>
                        <td class="p-0 border-0" id="med_favourit_0" style="vertical-align: top;"></td>


                        <td class="p-0 px-1 border-0">
                            <div class="" id="doseID" style="display: flex">
                                <select class="form-controlform-control-sm m-0 p-0  medicine_dose doseEdit select2"
                                    id="medicine_dose_0" name="medicine_dose[]"
                                    onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose');">
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
                                    onclick="prescriptionFunc.addMoreDropdownOptionV1(this,'.editDosButton');"
                                    data-qnty="0" data-dropdown_option_edit="edit_option_dose"
                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                    data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                    value="0">
                                    <span class="btn btn-success btn-sm" type="button"
                                        style="padding: 3px 5px 6px 5px !important"> <i class="fa fa-edit"></i></span>
                                </div>
                            </div>
                        </td>

                        <td class="p-0 px-1 border-0" hidden> {{-- hidden for ewmch requ --}}
                            <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity"
                                id="medicine_quantity_0" name="medicine_quantity[]">
                        </td>

                        <td class="p-0 px-1 border-0">
                            <div class="" id="routeId" style="display: flex;">
                                <select class="form-control form-control-sm m-0 p-0 medicine_route route_edit select2"
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
                                    onclick="prescriptionFunc.addMoreDropdownOptionV1(this,'.editRouteValue');"
                                    data-qnty="0" data-dropdown_option_edit="edit_option_route"
                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">
                                    <span class="btn btn-success btn-sm" type="button"
                                        style="padding: 3px 5px 6px 5px !important"> <i class="fa fa-edit"></i></span>
                                </div>
                                {{-- <div class="editRouteValue" id="medicine_route_0" style="display:none;"
                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editRouteValue');"
                                    data-qnty="0" data-dropdown_option_edit="edit_option_route"
                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">
                                    <span class="btn btn-success btn-sm" type="button"
                                        style="padding: 2px 2px 2px 2px !important"> <i class="fa fa-edit"></i></span>
                                </div> --}}
                            </div>
                        </td>

                        <td class="p-0 px-1 border-0" style="width: 15%;">
                            <div class="" id="instructionId" style="display: flex">
                                <select
                                    class="form-control form-control-sm m-0 p-0 medicine_instruction instructionEdit select2"
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
                                    onclick="prescriptionFunc.addMoreDropdownOptionV1(this,'.editInsButton');"
                                    data-qnty="0" data-dropdown_option_edit="edit_option"
                                    data-popup_header="Medicine Instruction" data-input_label="Instruction"
                                    data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal..)"
                                    value="0">
                                    <span class="btn btn-success btn-sm" type="button"
                                        style="padding: 3px 5px 6px 5px !important"> <i class="fa fa-edit"></i></span>
                                </div>
                            </div>
                        </td>


                        <td class="p-0 px-1 border-0 w-25">
                            <div class="input-group" id="durationId" style="width: 127%;">
                                <input type="text"
                                    class="form-control form-control-sm m-0 p-0 medicine_duration number_only"
                                    id="medicine_duration_type_0" name="medicine_duration_type[]" value="0"
                                    onkeyup="prescriptionFunc.calculateMedicineQnty(this)" maxlength="3" />
                                <select class="form-control medicine_duration_mu" id="medicine_duration_mu_0"
                                    name="medicine_duration_mu[]">
                                    <option value="0">Select</option>

                                    @if (!empty($meddurmu))
                                    @foreach ($meddurmu as $key => $dmu)
                                    @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                                    @if (Session::get('user.ses_hospital_code') != 'AMCSH')
                                    @if (strtoupper($key) == 'DAY')
                                    <option value="{{ strtoupper($key) }}" selected="selected">
                                        {{ $dmu['data'] }}
                                    </option>
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
                                        @if ($dmu['data'] == 'DAY')
                                        দিন
                                        @elseif($dmu['data'] == 'HOUR')
                                        ঘন্টা
                                        @elseif($dmu['data'] == 'WEEK')
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
                                        @if ($dmu['data'] == 'DAY')
                                        দিন
                                        @elseif($dmu['data'] == 'HOUR')
                                        ঘন্টা
                                        @elseif($dmu['data'] == 'WEEK')
                                        সপ্তাহ
                                        @elseif($dmu['data'] == 'MONTH')
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

                        <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_td_action_0"
                            width="10%">
                            <span class="btn btn-success btn-md" id="med_span"
                                data-favourit-action="{{ route('add-pres-favourit-list') }}"
                                data-multidose-action="{{ route('add-multidose') }}"
                                data-alternative-action="{{ route('alternative-medicine') }}"
                                data-lookup-code="MEDDT" onclick="prescriptionV2.addMedRow(this); previewTab()"> <i
                                    class="fa fa-plus"></i>
                            </span>
                        </td>
                    </tr>
                    {{-- @dd($dose);  {{dd($pat_med_rs)}}--}}
                    @if (!empty($pat_med_rs))
                    @php $i=1 @endphp

                    @php
                    // Initialize a dictionary to keep track of dose counts for each medicine item
                    $medicineDoseCount = [];
                    @endphp
                    @foreach ($pat_med_rs as $index => $med_row)
                    {{-- @if ($med_row->item_no_fk > 0) --}}
                    <tr class="border-0" id="tr_id_{{ $i }}" style="width: 70% !important;">
                        @php
                        if (!isset($medicineDoseCount)) {
                        $medicineDoseCount = [];
                        }

                        // Get brand name and item ID
                        $medicineItem = isset($med_row->brand_name)
                        ? trim($med_row->brand_name)
                        : 'Unknown';
                        $itemId = isset($med_row->item_no_fk) ? $med_row->item_no_fk : 0;
                        $generic_name = isset($med_row->generic_name) ? $med_row->generic_name : '';

                        // Normalize brand name: remove spaces, lowercase
                        $normalizedName = strtolower(preg_replace('/\s+/', '', $medicineItem));

                        // Create a unique key combining item_id and normalized brand name
                        $doseKey = $itemId . '_' . $normalizedName;

                        // Initialize dose count for the key
                        if (!isset($medicineDoseCount[$doseKey])) {
                        $medicineDoseCount[$doseKey] = 0;
                        }

                        // Increment and get dose number
                        $medicineDoseCount[$doseKey]++;
                        $doseNo = $medicineDoseCount[$doseKey];
                        @endphp

                        <td class="p-0 px-1 border-0" width="20%">

                            <!-- Display the medicine item ONLY for Dose 1 -->
                            @if ($doseNo == 1)
                            <input type="text"
                                class="form-control form-control-sm m-0 p-0 item_element bg-white same-item-name"
                                id="medicine_item_{{ $i }}" name="medicine_item[]"
                                placeholder="Generic / Brand" value="{{ $medicineItem }}"
                                style="border: 0px none;" readonly="readonly">
                            @endif

                            <!-- Hidden inputs -->
                            <input type="hidden" id="hdn_medicine_item_id_{{ $i }}"
                                name="hdn_medicine_item_id[]" value="{{ $itemId }}" />

                            <input type="hidden" id="hdn_genetic_id_{{ $i }}"
                                name="hdn_genetic_id[]" value="{{ $generic_name }}" />

                            <input type="hidden" id="hdn_report_serial_med_{{ $i }}"
                                name="hdn_report_serial_med[]" value="{{ $i }}" />

                            <input type="hidden" id="hidden_multidose_id_{{ $i }}"
                                name="multidose[]" value="{{ $med_row->multidose_txt }}" />

                            <!-- If dose > 1, show dose number visually -->
                            @if ($doseNo > 1)
                            <input type="hidden"
                                class="form-control form-control-sm m-0 p-0 item_element bg-white"
                                id="medicine_item_{{ $i }}" name="medicine_item[]"
                                placeholder="Generic / Brand" value="{{ $medicineItem }}"
                                style="border: 0px none;" readonly="readonly" />

                            <span class="dose-id-display"
                                style="color: #262323; background-color: rgb(221 164 152 / 18%); padding: 3px 15px; border-radius: 3px; font-weight: bold; display: inline-block; width: 100%; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                                Dose No: {{ $doseNo }}
                            </span>
                            @endif
                        </td>


                        <td class="p-0 border-0" id="alternative_id_{{ $i }}"
                            style="vertical-align: top;">
                        </td>
                        <td class="p-0 border-0" id="med_favourit_{{ $i }}"
                            style="vertical-align: top;">
                            <span class="float-right text-secondary mr-1 cursor-pointer"
                                style="font-size:11px;" title="Add To Favourite List"
                                onclick="prescriptionV2.addToPresFavouritListV2(this, '#pres-favourit-list-med')"
                                data-url="{{ route('add-pres-favourit-list') }}"
                                data-id="{{ $med_row->item_no_fk }}" data-name="{{ $med_row->brand_name }}"
                                data-type="MED" data-duration="{{ $med_row->duration }}"
                                data-route="{{ $med_row->route }}" data-dose="{{ $med_row->dosage }}"
                                data-quantity="{{ $med_row->item_qty }} data-continue=" {{ $med_row->continue_ind }}"
                                data-instruction="{{ $med_row->instruction_take }}"
                                data-duration-type="{{ $med_row->instruction_take }}"><i
                                    class="fa fa-star text-primary"></i></span> <br />
                            {{-- <span class="float-right text-secondary mr-1 cursor-pointer"
                                        data-modal="common-modal-xl" style="font-size:11px;"
                                        title="Add Multidose Medicine"
                                        onclick="prescriptionFunc.addMultidoseList(this)"
                                        data-action="{{ route('add-multidose') }}"
                            data-url="{{ route('add-pres-favourit-list') }}"
                            data-id="{{ $med_row->item_no_fk }}" data-name="{{ $med_row->brand_name }}"
                            data-type="MED" data-duration="{{ $med_row->duration }}"
                            data-route="{{ $med_row->route }}" data-dose="{{ $med_row->dosage }}"
                            data-quantity="{{ $med_row->item_qty }} data-continue="{{ $med_row->continue_ind }}"
                            data-instruction="{{ $med_row->instruction_take }}"
                            data-duration-type="{{ $med_row->instruction_take }}"
                            data-row-id="{{ $i }}"><i class="fa fa-medkit text-danger"></i>
                            </span> --}}
                        </td>

                        <td class="p-0 px-1 border-0">
                            <div class="" id="doseID" style="display: flex">
                                <div>

                                    <select
                                        class="form-control form-control-sm m-0 p-0 doseEdit medicine_dose select2"
                                        id="medicine_dose_{{ $i }}" name="medicine_dose[]"
                                        onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose'); prescriptionFunc.calculateMedicineQnty(this);">
                                        <option value="0">Select</option>
                                        <option data-qnty="0" data-dropdown_option="edit_option_dose"
                                            data-popup_header="Medicine Dose" data-input_Label="Dose"
                                            data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                            value="0">Add More</option>
                                        @php $external_option_ind = 1; @endphp

                                        @if (!empty($dose))
                                        @foreach ($dose as $key => $dmu)
                                        @php
                                        $cleanDose = trim((string)$med_row->dosage);
                                        $cleanKey = trim((string)$key);
                                        $isSelected = ($cleanDose === $cleanKey);
                                        if ($isSelected) {
                                        $external_option_ind = 0;
                                        }
                                        @endphp

                                        <option value="{{ $key }}" data-qnty="" {{ $isSelected ? 'selected' : '' }}>
                                            {{ $dmu['data'] }}
                                        </option>
                                        @endforeach
                                        @endif

                                        @if (!empty($med_row->dosage) && $external_option_ind === 1)
                                        <option data-qnty="" value="{{ $med_row->dosage }}" selected="selected">
                                            {{ $med_row->dosage }}
                                        </option>
                                        @endif
                                    </select>
                                </div>
                                <div class="editDosButton" id="medicine_dose_{{ $i }}"
                                    onclick="prescriptionFunc.addMoreDropdownOption(this,'.editDosButton');"
                                    data-qnty="0" data-dropdown_option_edit="edit_option_dose"
                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                    data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                    value="0">
                                    <span class="btn btn-success btn-sm" type="button"
                                        style="padding: 3px 5px 6px 5px !important"> <i
                                            class="fa fa-edit"></i></span>
                                </div>
                            </div>

                        </td>

                        <td class="p-0 px-1 border-0">
                            <div class="" id="routeId" style="display: flex">
                                <div>
                                    <select
                                        class="form-control form-control-sm m-0 p-0 medicine_route route_edit select2"
                                        id="medicine_route_{{ $i }}" name="medicine_route[]"
                                        onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');">
                                        <option value="0">Select</option>
                                        <option data-qnty="0" data-dropdown_option="add_more"
                                            data-popup_header="Medicine Route" data-input_Label="Route"
                                            data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                            value="0">Add More</option>
                                        @php $external_option_ind = 1; @endphp
                                        @if (!empty($route))
                                        @foreach ($route as $key => $dmu)
                                        @if ($med_row->route == $key)
                                        @php $external_option_ind = 0; @endphp
                                        <option data-qnty="" value="{{ $key }}"
                                            selected="selected">{{ $dmu['data'] }}</option>
                                        @else
                                        <option data-qnty="" value="{{ $key }}">
                                            {{ $dmu['data'] }}
                                        </option>
                                        @endif
                                        @endforeach
                                        @endif
                                        @if (!empty($med_row->route) && $external_option_ind == 1)
                                        <option data-qnty="" value="{{ $med_row->route }}"
                                            selected="selected">{{ $med_row->route }}</option>
                                        @endif
                                    </select>

                                </div>
                                <div class="editRouteValue" id="medicine_route_{{ $i }}"
                                    onclick="prescriptionFunc.addMoreDropdownOption(this,'.editRouteValue');"
                                    data-qnty="0" data-dropdown_option_edit="edit_option_route"
                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                    value="0">
                                    <span class="btn btn-success btn-sm" type="button"
                                        style="padding: 3px 5px 6px 5px !important"> <i
                                            class="fa fa-edit"></i></span>
                                </div>
                            </div>
                        </td>

                        <td class="p-0 px-1 border-0" hidden>
                            <input type="text"
                                class="form-control form-control-sm m-0 p-0 medicine_quantity"
                                id="medicine_quantity_{{ $i }}" name="medicine_quantity[]"
                                value="{{ $med_row->item_qty }}">
                        </td>

                        <td class="p-0 px-1 border-0">
                            <div class="" id="instructionId" style="display: flex">
                                <div>
                                    <select
                                        class="form-control form-control-sm m-0 p-0 medicine_instruction instructionEdit select2"
                                        id="instruction_{{ $i }}" name="instruction[]"
                                        onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');">
                                        <option value="0">Select</option>
                                        <option data-qnty="0" data-dropdown_option="add_more"
                                            data-popup_header="Medicine Instruction"
                                            data-input_Label="Instruction"
                                            data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal ...)"
                                            value="0">Add More</option>
                                        @php $external_option_ind = 1; @endphp
                                        @if (!empty($instructions))
                                        @foreach ($instructions as $key => $dmu)
                                        @if ($med_row->instruction_take == $key)
                                        @php $external_option_ind = 0; @endphp
                                        <option value="{{ $key }}" selected="selected">
                                            {{ $dmu['data'] }}
                                        </option>
                                        @else
                                        <option value="{{ $key }}">
                                            {{ $dmu['data'] }}
                                        </option>
                                        @endif
                                        @endforeach
                                        @endif
                                        @if (!empty($med_row->instruction_take) && $external_option_ind == 1)
                                        <option data-qnty="" value="{{ $med_row->instruction_take }}"
                                            selected="selected">{{ $med_row->instruction_take }}
                                        </option>
                                        @endif
                                    </select>
                                </div>
                                <div class="editInsButton" id="instruction_{{ $i }}"
                                    onclick="prescriptionFunc.addMoreDropdownOption(this,'.editInsButton');"
                                    data-qnty="0" data-dropdown_option_edit="edit_option"
                                    data-popup_header="Medicine Instruction" data-input_label="Instruction"
                                    data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal..)"
                                    value="0">
                                    <span class="btn btn-success btn-sm" type="button"
                                        style="padding: 3px 5px 6px 5px !important"> <i
                                            class="fa fa-edit"></i></span>
                                </div>
                            </div>
                        </td>
                        <td class="p-0 px-1 border-0 w-25">
                            <div class="input-group" id="durationId" style="width: 127%;">
                                <input type="text"
                                    class="form-control form-control-sm m-0 p-0 medicine_duration number_only"
                                    id="medicine_duration_type_{{ $i }}" name="medicine_duration_type[]"
                                    onkeyup="prescriptionFunc.calculateMedicineQnty(this)" maxlength="3"
                                    value="{{ $med_row->continue_ind == 1 || $med_row->duration == 'Continue' ? 'Continue' : $med_row->duration }}"
                                    {{ $med_row->continue_ind == 1 || $med_row->duration == 'Continue' ? 'readonly' : '' }} />
                                <select class="form-control medicine_duration_mu"
                                    id="medicine_duration_mu_{{ $i }}"
                                    name="medicine_duration_mu[]" {{ $med_row->continue_ind == 1 ? 'readonly' : '' }}>
                                    @if (!empty($meddurmu))
                                    @foreach ($meddurmu as $key => $dmu)
                                    @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                                    @php
                                    $durationMu = strtoupper(trim($med_row->duration_mu));
                                    $keyUpper = strtoupper(trim($key));
                                    @endphp

                                    @if ($durationMu == $keyUpper)
                                    <option value="{{ $keyUpper }}" selected="selected">
                                        {{ $dmu['data'] }}
                                    </option>
                                    @else
                                    <option value="{{ $keyUpper }}">
                                        {{ $dmu['data'] }}
                                    </option>
                                    @endif
                                    @else
                                    @if ($med_row->duration_mu == strtoupper($key))
                                    <option value="{{ strtoupper($key) }}"
                                        selected="selected"> দিন</option>
                                    @else
                                    <option value="{{ strtoupper($key) }}">
                                        @if ($dmu['data'] == 'DAY')
                                        দিন
                                        @elseif($dmu['data'] == 'HOUR')
                                        ঘন্টা
                                        @elseif($dmu['data'] == 'WEEK')
                                        সপ্তাহ
                                        @elseif($dmu['data'] == 'MONTH')
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
                            @if ($med_row->continue_ind == 1 || $med_row->continue_ind == '1' || $med_row->duration == 'Continue')
                           <input type="checkbox" id="is_continue_{{ $i }}"
                                name="is_continue[]"
                                onchange="prescriptionFunc.setContinueDuration(this)"
                                value="1" checked>
                            @else
                            {{-- {{ dd($med_row->duration }} --}}
                            <input type="checkbox" id="is_continue_{{ $i }}"
                                name="is_continue[]" onchange="prescriptionFunc.setContinueDuration(this)"
                                value="0">
                            @endif
                        </td>

                        <td class="p-0 px-1 border-0" style="vertical-align: top;"
                            id="med_td_action_{{ $i }}">
                            {{-- @if ($doseNo > 1)
                                                $cursor = "cursor:not-allowed;background-color:'#ccc' ";
                                            @endif --}}
                            <div class="btn-group" role="group" aria-label="Button group">
                                <span class="btn btn-danger btn-md" onclick="removeTableRowOnly(this)">
                                    <i class="fa fa-times"></i>
                                </span>
                                <button type="button"
                                    class="btn btn-primary btn-md add-multidose ml-3 @if ($doseNo > 1) readonly-btn @endif"
                                    onclick="prescriptionFunc.addMultiDoseRow(this)">
                                    <i class="fa fa-clone"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @php
                    $i++;
                    @endphp
                    {{-- @endif --}}
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
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
    $(document).ready(function() {
        // $('textarea').autosize();
        // $('.select2').select2();
        // $('.select2').select2({
        //         tags: true, // Enable adding new options
        //         placeholder: 'Select or type to add',
        //         allowClear: true // Allow clearing selection
        //     });

        $('.select2').select2({
            tags: true, // Enable adding new options
            placeholder: 'Select or type to add',
            allowClear: true, // Allow clearing selection
            templateResult: formatOption, // Format the display of options
            templateSelection: formatOption // Format the selected option
        });

        // Function to format the options with data attributes
        function formatOption(option) {
            if (!option.id) {
                return option.text; // Return the text if it's a new tag
            }
            const $option = $(
                `<span>${option.text}</span>`
            );

            // Accessing custom data attributes
            const dataQnty = $(option.element).data('qnty');
            if (dataQnty !== undefined) {
                $option.append(`${dataQnty}`);
            }

            return $option;
        }

    });


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
        console.log(item)
        console.log(item.su_name)
        $(".department_name").val(item.su_name)
        $('#doc_dept').find(":selected").val(item.serviceunit_no_fk);
        $('#doc_dept').find(":selected").text(item.su_name);
    }


    function deptWiseDoctor(thisElement) {
        var deptValue = $(thisElement).val();
        var title = 'Department Wise Doctor List';
        $.ajax({
            data: {
                deptValue: deptValue
            },
            url: "{{ url('prescription-department-wise-doctor') }}",
            type: 'post',
            beforeSend: function() {
                // blockUI();
            },
            success: function(data) {
                $('#dept_doctor_list_modal').html(data)
                $('#myModal').modal("show");
                $('#modal-title').html(title);
            },
            complete: function() {
                // $.unblockUI();
            }
        });

    }

    $('#txt_referred_doctor').on('input', function() {
        if ($(this).val() === '') {
            $('#ref_doc_card_hidn').val('');
        }
    });


    // prescriptionFunc.addMultiDoseRow = function (btn) {
    //     let currentRow = $(btn).closest('tr');
    //     let newRow = currentRow.clone();
    //     let lastRowId = parseInt(currentRow.attr('id').replace(/\D/g, "")) || 0;
    //     let newRowId = lastRowId + 1;

    //     // নতুন সারির ID আপডেট করুন
    //     newRow.attr('id', 'row_' + newRowId);

    //     newRow.find('input, select, textarea').each(function () {
    //         let oldId = $(this).attr('id');
    //         let oldName = $(this).attr('name');

    //         // নতুন ID সেট করা
    //         if (oldId) {
    //             let newId = oldId.replace(/\d+$/, newRowId);
    //             $(this).attr('id', newId);
    //         }

    //         // নতুন Name সেট করা
    //         if (oldName) {
    //             let newName = oldName.replace(/\d+$/, newRowId);
    //             $(this).attr('name', newName);
    //         }

    //         // ইনপুট ফিল্ডের মান কপি করা (hidden fields সহ)
    //         if ($(this).hasClass('item_element')) {
    //             $(this).val(currentRow.find('.item_element').val()); // ওষুধের নাম আগের সারি থেকে কপি করা
    //         } else {
    //             $(this).val(currentRow.find(`[id='${oldId}']`).val()); // অন্যান্য ইনপুটের মান কপি করা
    //         }
    //     });

    //     // নতুন সারির অ্যাকশন বাটনের ID আপডেট করুন
    //     newRow.find("[id^='med_td_action_']").attr("id", "med_td_action_" + newRowId);

    //     // নতুন সারিটি বর্তমান সারির নিচে যোগ করুন
    //     currentRow.after(newRow);
    // };

    // prescriptionFunc.addMultiDoseRow = function(btn) {
    //     let currentRow = $(btn).closest('tr');
    //     let newRow = currentRow.clone();
    //     let lastRowId = parseInt(currentRow.attr('id').replace(/\D/g, "")) || 0;
    //     let newRowId = lastRowId + 1;
    //     let doseNo = newRowId; // নতুন সারির জন্য dose number সেট করা

    //     // নতুন সারির ID আপডেট করুন
    //     newRow.attr('id', 'row_' + newRowId);

    //     newRow.find('input, select, textarea').each(function() {
    //         let oldId = $(this).attr('id');
    //         let oldName = $(this).attr('name');

    //         // নতুন ID সেট করা
    //         if (oldId) {
    //             let newId = oldId.replace(/\d+$/, newRowId);
    //             $(this).attr('id', newId);

    //             // যদি ID "medicine_item_" দিয়ে শুরু হয়, তাহলে name পরিবর্তন করে "dose_doseNo" করুন
    //             if (oldId.startsWith('medicine_item_')) {
    //                 $(this).attr('name', 'dose_' + doseNo);
    //             }
    //         }

    //         console.log(oldId, oldName, newRowId);

    //         // অন্যান্য Name আপডেট করা (medicine_item বাদে)
    //         if (oldName && !oldId.startsWith('medicine_item_')) {
    //             let newName = oldName.replace(/\d+$/, newRowId);
    //             $(this).attr('name', newName);
    //         }

    //         // ইনপুট ফিল্ডের মান কপি করা (hidden fields সহ)
    //         if ($(this).hasClass('item_element')) {
    //             $(this).val(currentRow.find('.item_element').val()); // ওষুধের নাম আগের সারি থেকে কপি করা
    //         } else {
    //             $(this).val(currentRow.find(`[id='${oldId}']`).val()); // অন্যান্য ইনপুটের মান কপি করা
    //         }
    //     });

    //     // নতুন সারির অ্যাকশন বাটনের ID আপডেট করুন
    //     newRow.find("[id^='med_td_action_']").attr("id", "med_td_action_" + newRowId);



    //     // নতুন সারিটি বর্তমান সারির নিচে যোগ করুন
    //     currentRow.after(newRow);
    // };

    //     prescriptionFunc.addMultiDoseRow = function(btn) {
    //     let currentRow = $(btn).closest('tr');
    //     let newRow = currentRow.clone();
    //     let lastRowId = parseInt(currentRow.attr('id').replace(/\D/g, "")) || 0;
    //     let newRowId = lastRowId + 1;
    //     let doseNo = newRowId; // নতুন সারির জন্য dose number সেট করা

    //     // নতুন সারির ID আপডেট করুন
    //     newRow.attr('id', 'row_' + newRowId);

    //     newRow.find('input, select, textarea').each(function() {
    //         let oldId = $(this).attr('id');
    //         let oldName = $(this).attr('name');

    //         // নতুন ID সেট করা
    //         if (oldId) {
    //             let newId = oldId.replace(/\d+$/, newRowId);
    //             $(this).attr('id', newId);

    //             // যদি ID "medicine_item_" দিয়ে শুরু হয়, তখন name পরিবর্তন এবং ইনপুটে রঙ লাল করা
    //             if (oldId.startsWith('medicine_item_')) {
    //                 $(this).css('border', '1px solid red'); // ইনপুটের বর্ডার লাল রং
    //             }
    //         }

    //         console.log(oldId, oldName, newRowId);

    //         // অন্যান্য Name আপডেট করা (medicine_item বাদে)
    //         if (oldName && !oldId.startsWith('medicine_item_')) {
    //             let newName = oldName.replace(/\d+$/, newRowId);
    //             // $(this).attr('name', newName);
    //         }

    //         // ইনপুট ফিল্ডের মান কপি করা (hidden fields সহ)
    //         if ($(this).hasClass('item_element')) {
    //             $(this).val(currentRow.find('.item_element').val()); // ওষুধের নাম আগের সারি থেকে কপি করা
    //         } else {
    //             $(this).val(currentRow.find(`[id='${oldId}']`).val()); // অন্যান্য ইনপুটের মান কপি করা
    //         }
    //     });

    //     // নতুন সারির অ্যাকশন বাটনের ID আপডেট করুন
    //     newRow.find("[id^='med_td_action_']").attr("id", "med_td_action_" + newRowId);

    //     // নতুন সারিটি বর্তমান সারির নিচে যোগ করুন
    //     currentRow.after(newRow);
    // };

    // prescriptionFunc.addMultiDoseRow = function(btn) {
    //     let currentRow = $(btn).closest('tr');
    //     let newRow = currentRow.clone();
    //     let lastRowId = parseInt(currentRow.attr('id').replace(/\D/g, "")) || 0;
    //     let newRowId = lastRowId + 1;
    //     let doseNo = newRowId; // নতুন সারির জন্য dose number সেট করা

    //     // নতুন সারির ID আপডেট করুন
    //     newRow.attr('id', 'row_' + newRowId);

    //     newRow.find('input, select, textarea').each(function() {
    //         let oldId = $(this).attr('id');
    //         let oldName = $(this).attr('name');

    //         // নতুন ID সেট করা
    //         if (oldId) {
    //             let newId = oldId.replace(/\d+$/, newRowId);
    //             $(this).attr('id', newId);

    //             // যদি ID "medicine_item_" দিয়ে শুরু হয়, তখন name পরিবর্তন এবং ইনপুটে রঙ লাল করা
    //             if (oldId.startsWith('medicine_item_')) {
    //                 $(this).attr('name', 'dose_' + doseNo);
    //                 $(this).css('border', '1px solid red'); // ইনপুটের বর্ডার লাল রং

    //                 // ইনপুটটি hide করা
    //                 $(this).hide();

    //                 // একটি স্প্যান তৈরি করা
    //                 let span = $('<span></span>').text('Dose ID: ' + doseNo);

    //                 // স্প্যানটিকে ইনপুটের জায়গায় সন্নিবেশ করা
    //                 $(this).after(span);
    //             }
    //         }

    //         console.log(oldId, oldName, newRowId);

    //         // অন্যান্য Name আপডেট করা (medicine_item বাদে)
    //         if (oldName && !oldId.startsWith('medicine_item_')) {
    //             let newName = oldName.replace(/\d+$/, newRowId);
    //             // $(this).attr('name', newName);
    //         }

    //         // ইনপুট ফিল্ডের মান কপি করা (hidden fields সহ)
    //         if ($(this).hasClass('item_element')) {
    //             $(this).val(currentRow.find('.item_element').val()); // ওষুধের নাম আগের সারি থেকে কপি করা
    //         } else {
    //             $(this).val(currentRow.find(`[id='${oldId}']`).val()); // অন্যান্য ইনপুটের মান কপি করা
    //         }
    //     });

    //     // নতুন সারির অ্যাকশন বাটনের ID আপডেট করুন
    //     newRow.find("[id^='med_td_action_']").attr("id", "med_td_action_" + newRowId);

    //     // নতুন সারিটি বর্তমান সারির নিচে যোগ করুন
    //     currentRow.after(newRow);
    // };






    // prescriptionFunc.addMultiDoseRow = function(btn) {
    //     let currentRow = $(btn).closest('tr');
    //     let newRow = currentRow.clone();
    //     let lastRowId = parseInt(currentRow.attr('id').replace(/\D/g, "")) || 0;
    //     let newRowId = lastRowId + 1;
    //     let doseNo = newRowId; // নতুন সারির জন্য dose number সেট করা

    //     // নতুন সারির ID আপডেট করুন
    //     newRow.attr('id', 'row_' + newRowId);

    //     newRow.find('input, select, textarea').each(function() {
    //         let oldId = $(this).attr('id');
    //         let oldName = $(this).attr('name');

    //         // নতুন ID সেট করা
    //         if (oldId) {
    //             let newId = oldId.replace(/\d+$/, newRowId);
    //             $(this).attr('id', newId);

    //             // যদি ID "medicine_item_" দিয়ে শুরু হয়, তখন name পরিবর্তন এবং ইনপুটে রঙ লাল করা
    //             if (oldId.startsWith('medicine_item_')) {
    //                 $(this).attr('name', 'dose_' + doseNo);
    //                 $(this).css('border', '1px solid red'); // ইনপুটের বর্ডার লাল রং

    //                 // পূর্ববর্তী কোনো span থাকলে সরিয়ে দিন
    //                 $(this).siblings('span').remove();

    //                 // ইনপুটটি hide করা
    //                 $(this).hide();

    //                 // একটি স্প্যান তৈরি করা
    //                 let span = $('<span></span>').text('Dose ID: ' + doseNo);

    //                 // স্প্যানটিকে ইনপুটের জায়গায় সন্নিবেশ করা
    //                 $(this).after(span);
    //             }
    //         }

    //         console.log(oldId, oldName, newRowId);

    //         // অন্যান্য Name আপডেট করা (medicine_item বাদে)
    //         if (oldName && !oldId.startsWith('medicine_item_')) {
    //             let newName = oldName.replace(/\d+$/, newRowId);
    //             $(this).attr('name', newName);
    //         }

    //         // ইনপুট ফিল্ডের মান কপি করা (hidden fields সহ)
    //         if ($(this).hasClass('item_element')) {
    //             $(this).val(currentRow.find('.item_element').val()); // ওষুধের নাম আগের সারি থেকে কপি করা
    //         } else {
    //             $(this).val(currentRow.find(`[id='${oldId}']`).val()); // অন্যান্য ইনপুটের মান কপি করা
    //         }
    //     });

    //     // নতুন সারির অ্যাকশন বাটনের ID আপডেট করুন
    //     newRow.find("[id^='med_td_action_']").attr("id", "med_td_action_" + newRowId);

    //     // নতুন সারিটি বর্তমান সারির নিচে যোগ করুন
    //     currentRow.after(newRow);
    // };





    // 12:10

    // prescriptionFunc.addMultiDoseRow = function(btn) {
    //     let currentRow = $(btn).closest('tr');
    //     let newRow = currentRow.clone();

    //     let lastRowId = parseInt(currentRow.attr('id').replace(/\D/g, "")) || 0;
    //     let newRowId = lastRowId + 1;

    //     // Find the medicine item ID in the current row
    //     let medicineInput = currentRow.find("[id^='medicine_item_']");
    //     let medicineId = medicineInput.val(); // Get the selected medicine name or ID

    //     // Count existing doses for this specific medicine
    //     let existingDoses = currentRow
    //         .parent()
    //         .find("tr")
    //         .filter(function () {
    //             return $(this).find("[id^='medicine_item_']").val() === medicineId;
    //         }).length;

    //     let doseNo = existingDoses + 1; // Increment dose number only for the same medicine

    //     // নতুন সারির ID আপডেট করুন
    //     newRow.attr('id', 'row_' + newRowId);

    //     newRow.find('input, select, textarea').each(function () {
    //         let oldId = $(this).attr('id');
    //         let oldName = $(this).attr('name');

    //         // নতুন ID সেট করা
    //         if (oldId) {
    //             let newId = oldId.replace(/\d+$/, newRowId);
    //             $(this).attr('id', newId);

    //             // যদি ID "medicine_item_" দিয়ে শুরু হয়, তাহলে name পরিবর্তন করে "dose_doseNo" করুন
    //             if (oldId.startsWith('medicine_item_')) {
    //                 $(this).attr('name', 'dose_' + doseNo);
    //                 $(this).css('border', '1px solid red');

    //                 // পূর্ববর্তী কোনো span থাকলে সরিয়ে দিন
    //                 $(this).siblings('span').remove();

    //                 // ইনপুটটি লুকিয়ে ফেলা
    //                 $(this).hide();

    //                 // একটি স্প্যান তৈরি করা
    //                 let span = $('<span></span>').text('Dose ID: ' + doseNo);

    //                 // স্প্যানটিকে ইনপুটের জায়গায় সন্নিবেশ করা
    //                 $(this).after(span);
    //             }
    //         }

    //         console.log(oldId, oldName, newRowId);

    //         // অন্যান্য Name আপডেট করা (medicine_item বাদে)
    //         if (oldName && !oldId.startsWith('medicine_item_')) {
    //             let newName = oldName.replace(/\d+$/, newRowId);
    //             // $(this).attr('name', newName);
    //         }

    //         // ইনপুট ফিল্ডের মান কপি করা (hidden fields সহ)
    //         if ($(this).hasClass('item_element')) {
    //             $(this).val(currentRow.find('.item_element').val()); // ওষুধের নাম আগের সারি থেকে কপি করা
    //         } else {
    //             $(this).val(currentRow.find(`[id='${oldId}']`).val()); // অন্যান্য ইনপুটের মান কপি করা
    //         }
    //     });

    //     // নতুন সারির অ্যাকশন বাটনের ID আপডেট করুন
    //     newRow.find("[id^='med_td_action_']").attr("id", "med_td_action_" + newRowId);

    //     // নতুন সারিটি বর্তমান সারির নিচে যোগ করুন
    //     currentRow.after(newRow);
    // };

    // update code
    // prescriptionFunc.addMultiDoseRow = function(btn) {
    //     let currentRow = $(btn).closest('tr');
    //     let newRow = currentRow.clone();

    //     let lastRowId = parseInt(currentRow.attr('id').replace(/\D/g, "")) || 0;
    //     let newRowId = lastRowId + 1;

    //     // নতুন সারির ID আপডেট করুন
    //     newRow.attr('id', 'row_' + newRowId);

    //     newRow.find('input, select, textarea').each(function () {
    //         let oldId = $(this).attr('id');
    //         let oldName = $(this).attr('name');

    //         // নতুন ID সেট করা
    //         if (oldId) {
    //             let newId = oldId.replace(/\d+$/, newRowId);
    //             $(this).attr('id', newId);
    //         }

    //         // নতুন Name সেট করা
    //         if (oldName) {
    //             let newName = oldName.replace(/\d+$/, newRowId);
    //             $(this).attr('name', newName);
    //         }

    //         // ইনপুটের মান খালি করা
    //         if (!$(this).hasClass('item_element')) {
    //             $(this).val('');
    //         }
    //     });

    //     // ========================== //
    //     // 🔥 **Fix: Remove Extra Select2 Elements** //
    //     // ========================== //
    //     newRow.find(".select2").each(function () {
    //         let $this = $(this);

    //         // পুরানো Select2 এলিমেন্ট মুছতে হবে
    //         $this.removeClass("select2-hidden-accessible");
    //         $this.next(".select2-container").remove();

    //         // নতুনভাবে Select2 অ্যাপ্লাই করুন
    //         $this.select2({
    //             tags: true, // Enable adding new options
    //             placeholder: 'Select or type to add',
    //             allowClear: true, // Allow clearing selection
    //             templateResult: formatOption, // Format the display of options
    //             templateSelection: formatOption // Format the selected option
    //         });
    //     });

    //     // নতুন সারিটি বর্তমান সারির নিচে যোগ করুন
    //     currentRow.after(newRow);
    // };

    // // ============================== //
    // // 🟢 **Format Select2 Options** //
    // // ============================== //
    // function formatOption(option) {
    //     if (!option.id) {
    //         return option.text; // Return the text if it's a new tag
    //     }
    //     const $option = $(`<span>${option.text}</span>`);

    //     // Custom data attributes (e.g., quantity)
    //     const dataQnty = $(option.element).data('qnty');
    //     if (dataQnty !== undefined) {
    //         $option.append(` (Qty: ${dataQnty})`);
    //     }

    //     return $option;
    // }









    // right function

    // prescriptionFunc.addMultiDoseRow = function(btn) {
    //     let currentRow = $(btn).closest('tr');
    //     let newRow = currentRow.clone();

    //     let lastRowId = parseInt(currentRow.attr('id').replace(/\D/g, "")) || 0;
    //     let newRowId = lastRowId + 1;

    //     // Find the medicine item ID in the current row
    //     let medicineInput = currentRow.find("[id^='medicine_item_']");
    //     let medicineId = medicineInput.val(); // Get the selected medicine name or ID

    //     // Count existing doses for this specific medicine
    //     let existingDoses = currentRow
    //         .parent()
    //         .find("tr")
    //         .filter(function () {
    //             return $(this).find("[id^='medicine_item_']").val() === medicineId;
    //         }).length;

    //     let doseNo = existingDoses + 1; // Increment dose number only for the same medicine

    //     // নতুন সারির ID আপডেট করুন
    //     newRow.attr('id', 'row_' + newRowId);

    //     newRow.find('input, select, textarea').each(function () {
    //         let oldId = $(this).attr('id');
    //         let oldName = $(this).attr('name');

    //         // নতুন ID সেট করা
    //         if (oldId) {
    //             let newId = oldId.replace(/\d+$/, newRowId);
    //             $(this).attr('id', newId);
    //         }

    //         // নতুন Name সেট করা
    //         if (oldName) {
    //             let newName = oldName.replace(/\d+$/, newRowId);
    //             $(this).attr('name', newName);
    //         }

    //         // **🔥 Dose ID দেখানোর জন্য স্প্যান যোগ করা **
    //         if (oldId && oldId.startsWith('medicine_item_')) {
    //             $(this).attr('name', 'dose_' + doseNo);
    //             $(this).css('border', '1px solid red');

    //             // পূর্ববর্তী কোনো span থাকলে সরিয়ে দিন
    //             $(this).siblings('span').remove();

    //             // ইনপুটটি লুকিয়ে ফেলা
    //             $(this).hide();

    //             // একটি স্প্যান তৈরি করা
    //             let span = $('<span class="dose-id-display"></span>').text('Dose ID: ' + doseNo);

    //             // স্প্যানটিকে ইনপুটের জায়গায় সন্নিবেশ করা
    //             $(this).after(span);
    //         }
    //     });

    //     // ========================== //
    //     // 🔥 **Fix: Remove Extra Select2 Elements** //
    //     // ========================== //
    //     newRow.find(".select2").each(function () {
    //         let $this = $(this);

    //         // পুরানো Select2 এলিমেন্ট মুছতে হবে
    //         $this.removeClass("select2-hidden-accessible");
    //         $this.next(".select2-container").remove();

    //         // নতুনভাবে Select2 অ্যাপ্লাই করুন
    //         $this.select2({
    //             tags: true, // Enable adding new options
    //             placeholder: 'Select or type to add',
    //             allowClear: true, // Allow clearing selection
    //             templateResult: formatOption, // Format the display of options
    //             templateSelection: formatOption // Format the selected option
    //         });
    //     });

    //     // নতুন সারিটি বর্তমান সারির নিচে যোগ করুন
    //     currentRow.after(newRow);
    // };

    // // ============================== //
    // // 🟢 **Format Select2 Options** //
    // // ============================== //
    // function formatOption(option) {
    //     if (!option.id) {
    //         return option.text; // Return the text if it's a new tag
    //     }
    //     const $option = $(`<span>${option.text}</span>`);

    //     // Custom data attributes (e.g., quantity)
    //     const dataQnty = $(option.element).data('qnty');
    //     if (dataQnty !== undefined) {
    //         $option.append(` (Qty: ${dataQnty})`);
    //     }

    //     return $option;
    // }


    prescriptionFunc.addMultiDoseRow = function(btn) {
        let currentRow = $(btn).closest('tr');
        let newRow = currentRow.clone();

        let lastRowId = parseInt(currentRow.attr('id').replace(/\D/g, "")) || 0;
        let newRowId = lastRowId + 1;

        // ✅ Medicine ID বের করা
        let medicineInput = currentRow.find("[id^='medicine_item_']");
        let medicineId = medicineInput.val();

        // ✅ ওই medicine-এর মোট কয়টা dose আগে থেকেই আছে
        let existingDoses = currentRow
            .parent()
            .find("tr")
            .filter(function() {
                return $(this).find("[id^='medicine_item_']").val() === medicineId;
            }).length;

        let doseNo = existingDoses + 1; // FIFO model → ক্রমানুসারে dose নম্বর

        // ✅ নতুন row এর ID আপডেট
        newRow.attr("id", "row_" + newRowId);

        newRow.find("input, select, textarea").each(function() {
            let oldId = $(this).attr("id");
            let oldName = $(this).attr("name");

            if (oldId) {
                let newId = oldId.replace(/\d+$/, newRowId);
                $(this).attr("id", newId);
            }
            if (oldName) {
                let newName = oldName.replace(/\d+$/, newRowId);
                $(this).attr("name", newName);
            }

            // ✅ Medicine ফিল্ড hide করে dose no দেখানো
            if (oldId && oldId.startsWith("medicine_item_")) {
                $(this).hide().siblings("span").remove();

                let span = $(
                    `<span class="dose-id-display">Dose No: ${doseNo}</span>`
                ).css({
                    color: "#262323",
                    "background-color": "rgb(221 164 152 / 18%)",
                    padding: "3px 15px",
                    "border-radius": "8px",
                    "font-weight": "bold",
                    display: "inline-block",
                    width: "100%",
                    "font-size": "14px",
                    "text-transform": "uppercase",
                    "letter-spacing": "0.5px",
                    transition: "all 0.3s ease",
                });

                $(this).after(span);
            } else {
                // ✅ Dose value, route, instruction reset না করে কপি রাখুন
                if ($(this).is("input")) {
                    if ($(this).attr("type") !== "hidden") {
                        $(this).val($(this).val()); // copy value
                    }
                } else if ($(this).is("select")) {
                    $(this).val($(this).val()).trigger("change");
                } else if ($(this).is("textarea")) {
                    $(this).text($(this).text());
                }
            }
        });

        // ✅ MultiDose বাটন disable
        newRow.find(".add-multidose").prop("disabled", true).css({
            "background-color": "#ccc",
            cursor: "not-allowed",
        });

        // ✅ Select2 পুনরায় init করা
        newRow.find(".select2").each(function() {
            let $this = $(this);
            $this.next(".select2-container").remove();
            $this.select2({
                tags: true,
                placeholder: "Select or type to add",
                allowClear: true,
                templateResult: formatOption,
                templateSelection: formatOption,
            });
        });

        // ✅ FIFO: একই medicine-এর শেষ dose এর নিচে বসানো
        let lastDoseRow = currentRow
            .parent()
            .find("tr")
            .filter(function() {
                return $(this).find("[id^='medicine_item_']").val() === medicineId;
            })
            .last();

        lastDoseRow.after(newRow);
    };


    // ============================== //
    // 🟢 **Format Select2 Options** //
    // ============================== //
    function formatOption(option) {
        if (!option.id) {
            return option.text; // Return the text if it's a new tag
        }
        const $option = $(`<span>${option.text}</span>`);

        // Custom data attributes (e.g., quantity)
        const dataQnty = $(option.element).data('qnty');
        if (dataQnty !== undefined) {
            $option.append(` (Qty: ${dataQnty})`);
        }

        return $option;
    }


    // Trigger previewTab when clicking anywhere on the page
    $(document).click(function() {
        previewTab();
    });

    $('input, textarea, select').change(function() {
        previewTab();
    });

    $('.medicine_duration').on('input change', function() {
        previewTab();
    });
    $('.add-multidose').on('click', function() {
        previewTab();
    });




    function medicationUpdate(thisElement) {
        console.log('For Medicine')

        $(thisElement).parents("table").find("tr").removeClass("bg-success");
        var action = $(thisElement).attr("data-action");
        var disease_action = $(thisElement).attr("data-disease_action");
        var temp = $(thisElement).attr("data-temp");
        var hdn_su_no = $("#hdn_su_no").val();
        var app_id = $("#hdn_appointment_id").val();
        $(thisElement).parents("tr").addClass("bg-success");
        var prescription_id = $(thisElement).attr("data-presc");
        var dtls_action = $(thisElement).attr("data-dtls-action");
        var hdn_appointment_id = $("#hdn_appointment_id").val();

        // $.unblockUI();
        $.ajax({
            data: {
                hdn_su_no: hdn_su_no,
                hdn_appointment_id: hdn_appointment_id
            },
            url: dtls_action,
            type: "get",
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                console.log(response['pr_arr'])
                var doges = response['dose'];
                var route = response['route'];
                var duration = response['duration'];
                var instructions = response['instructions'];
                let pat_med_rs = response['pat_med_rs'];
                let meddurmu = response['meddurmu'];
                let cc_arr = response['cc_arr'];
                let ch_arr = response['ch_arr'];
                let icd_arr = response['icd_arr'];
                let lmp = response['lmp'];
                let in_arr = response['in_arr'];
                let inf_arr = response['inf_arr'];
                let find_arr = response['find_arr'];
                let adv_arr = response['ad_arr'];
                let pr_arr = response['pr_arr'];
                let acup_arr = response['acup_arr'];
                let ptet_arr = response['ptet_arr'];
                let ptte_arr = response['ptte_arr'];
                let duration_mu_phy = response['duration_mu_phy'];
                console.log(pr_arr + 'testing');
                // $("#data-append-to").html("");

                let tableBody = $('#data-append-to');
                // $('#data-append-to tr').not(':first').remove();
                $('#data-append-to tr').slice(1).remove();
                // var selectElement='';
                let medicineDoseCount = {};
                $.each(pat_med_rs, function(index, med_row) {
                    selectDoseElement =
                        `<div class="" id="doseID" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 medicine_dose doseEdit select2 select2-hidden-accessible" id="medicine_dose_${index + 1}" name="medicine_dose[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose'); prescriptionFunc.calculateMedicineQnty(this);" data-select2-id="medicine_dose_${index + 1}" tabindex="-1" aria-hidden="true"> <option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Route" data-input_label="Route" data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">Add More</option>`;
                    $.each(doges, function(key, value) {
                        console.log(value.data)
                        const isDoseSelected = med_row.dosage === value.data ?
                            `<option value="${value.data}" selected>${value.data}</option>` :
                            ` <option value="${value.data}">${value.data}</option>`;

                        const text_dose = med_row.dosage != value.data ?
                            `<option value="${med_row.dosage}" selected>${med_row.dosage}</option>` :
                            '';
                        // `<option value="0" selected>${med_row.dosage}</option>`
                        // med_row.dosage === value.data
                        selectDoseElement += isDoseSelected + text_dose;
                    });
                    selectDoseElement += `</select></div> <div class="editDosButton" id="medicine_dose_${index + 1}"
                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editDosButton');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option_dose"
                                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                                    data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 3px 5px 6px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div></div>`;

                    console.log(selectDoseElement)

                    selectRouteElement =
                        `<div class="" id="routeId" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 route_edit medicine_route select2 select2-hidden-accessible" id="medicine_route_${index + 1}" name="medicine_route[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');" data-select2-id="medicine_route_${index + 1}" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Route" data-input_label="Route" data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">Add More</option>`;
                    $.each(route, function(key, value) {
                        const isRouteSelected = med_row.route === value.data ? 'selected' :
                            '';
                        selectRouteElement +=
                            `<option value="${value.data}" ${isRouteSelected}>${value.data}</option>`

                    });
                    selectRouteElement += `</select> </div>
                                                <div class="editRouteValue" id="medicine_route_${index + 1}"
                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editRouteValue');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option_route"
                                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 3px 5px 6px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div>
                                            </div>`;

                    selectInstructionElement =
                        `<div class="" id="instructionId" style="display: flex">
                                                <div style="width:100%;"><select class="form-control form-control-sm m-0 p-0 instructionEdit medicine_instruction select2 select2-hidden-accessible" id="instruction_${index + 1}" name="instruction[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');" data-select2-id="instruction_${index + 1}" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Instruction" data-input_label="Instruction" data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal ...)" value="0">Add More</option>`;
                    $.each(instructions, function(key, value) {
                        const isInstructionSelected = med_row.instruction_take === value
                            .data ? 'selected' : '';
                        selectInstructionElement +=
                            `<option value="${value.data}" ${isInstructionSelected}>${value.data}</option>`

                    });
                    selectInstructionElement += `</select></div style="width:100%;">
                                                <div class="editInsButton" id="instruction_${index + 1}"

                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editInsButton');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option"
                                                    data-popup_header="Medicine Instruction"
                                                    data-input_label="Instruction"
                                                    data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal..)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 3px 5px 6px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div>
                                            </div>`;

                    selectDurationElement =
                        `<select class="form-control form-control-sm m-0 p-0 medicine_instruction select2 select2-hidden-accessible" id="instruction_${index + 1}" name="instruction[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');" data-select2-id="instruction_${index + 1}" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Instruction" data-input_label="Instruction" data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal ...)" value="0">Add More</option>`;
                    $.each(duration, function(key, value) {
                        const isDurationSelected = med_row.duration === value.data ?
                            'selected' : '';
                        selectDurationElement +=
                            `<option value="${value.data}" ${isDurationSelected}>${value.data}</option>`

                    });
                    selectDurationElement += `</select>`;

                    selectDurationMuElement =
                        `<select class="form-control medicine_duration_mu" id="medicine_duration_mu_${index + 1}" name="medicine_duration_mu[]" >`;
                    $.each(meddurmu, function(key, value) {
                        // const isDurationMuSelected = med_row.duration_mu == value.data
                        //     .toUpperCase() ? 'selected' : '';
                       const isDurationMuSelected =
                        med_row.duration_mu?.trim().toUpperCase() === value.data?.trim().toUpperCase()
                            ? "selected"
                            : "";


                        selectDurationMuElement +=
                            `<option value="${value.data}" ${isDurationMuSelected}>${value.data}</option>`

                    });
                    selectDurationMuElement += `</select>`;

                    // if (med_row.item_no_fk > 0) {


                    // Initialize medicineDoseCount if it doesn't exist
                    // window.medicineDoseCount = window.medicineDoseCount || {};
                    // var medicineItem = med_row.brand_name || 'Unknown';
                    // var itemId = med_row.item_no_fk || 0;
                    // var doseNo = 0;
                    // var itemIdStr = String(itemId);
                    // window.medicineDoseCount[itemIdStr] = (window.medicineDoseCount[itemIdStr] || 0) + 1;
                    // doseNo = window.medicineDoseCount[itemIdStr];
                    // if (doseNo > 0) {
                    //     console.log('Dose number for item ID ' + itemId + ' is: ' + doseNo);
                    //     console.log('Item Name: ' + medicineItem);
                    // } else {
                    //     console.log('No doses to process for item ID ' + itemId + '.');
                    // }
                    const medicineItem = med_row.brand_name ?
                        med_row.brand_name.trim() :
                        "Unknown";
                    const itemId = med_row.item_no_fk || 0;
                    const generic_name = med_row && med_row.generic_name ? med_row.generic_name :
                        '';

                    // Clean the brand name (remove spaces, lowercase)
                    const normalizedName = medicineItem
                        .toLowerCase()
                        .replace(/\s+/g, "");

                    // Unique key: itemId + brandName
                    const doseKey = `${itemId}_${normalizedName}`;

                    // Initialize count if not exist
                    if (!medicineDoseCount[doseKey]) {
                        medicineDoseCount[doseKey] = 0;
                    }

                    // Increment dose number
                    medicineDoseCount[doseKey]++;
                    const doseNo = medicineDoseCount[doseKey];

                    let $row = `<tr class="border-0" id="tr_id_${index + 1}">


                             <td class="p-0 px-1 border-0" width="20%">
                                ${
                                    doseNo === 1
                                        ? `
                                    <input type="text"
                                        class="form-control form-control-sm m-0 p-0 item_element bg-white"
                                        id="medicine_item_${index + 1}" name="medicine_item[]"
                                        placeholder="Generic / Brand" value="${medicineItem}"
                                        style="border: 0px none;" readonly="readonly">`
                                        : ""
                                }

                                <input type="hidden" id="hdn_medicine_item_id_${index + 1}"
                                    name="hdn_medicine_item_id[]" value="${itemId}">
                                    <input type="hidden" id="hdn_genetic_id_${index + 1}"
                                        name="hdn_genetic_id[]" value="${generic_name}">
                                <input type="hidden" id="hdn_report_serial_med_${index + 1}"
                                    name="hdn_report_serial_med[]" value="1">

                                <input type="hidden" id="hidden_multidose_id_${index + 1}"
                                    name="multidose[]" value="${med_row.multidose_txt}">

                                ${
                                    doseNo > 1
                                        ? `
                                    <input type="hidden"
                                        class="form-control form-control-sm m-0 p-0 item_element bg-white"
                                        id="medicine_item_${index + 1}" name="medicine_item[]"
                                        placeholder="Generic / Brand" value="${medicineItem}"
                                        style="border: 0px none;" readonly="readonly">

                                    <span class="dose-id-display"
                                        style="color: #262323; background-color: rgb(221 164 152 / 18%); padding: 3px 15px; border-radius: 8px; font-weight: bold; display: inline-block; width: 100%; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Dose No: ${doseNo}
                                    </span>
                                    `
                                        : ""
                                }
                            </td>



                            <td class="p-0 border-0" id="alternative_id_${
                                index + 1
                            }" style="vertical-align: top;">


                            </td>

                            <td class="p-0 border-0" id="med_favourit_${
                                index + 1
                            }" style="vertical-align: top;">
                               <span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionV2.addToPresFavouritListV2(this, '#pres-favourit-list-med')" data-url="http://localhost/Nextgen/h360/public/add-pres-favourit-list" data-id="${med_row.item_no_fk}" data-name="${med_row.brand_name}" data-type="MED" data-duration="${med_row.duration}" data-route="${med_row.route}" data-dose="${med_row.dosage}" data-quantity="${med_row.quantity}" data-continue="${med_row.is_continue}" data-instruction="${med_row.instruction}" data-duration-type="${med_row.duration_type}"><i class="fa fa-star text-primary"></i></span>
                            </td>

                            <td class="p-0 px-1 border-0">
                              ${selectDoseElement}
                            </td>

                            <td class="p-0 px-1 border-0">
                              ${selectRouteElement}
                            </td>

                            <td class="p-0 px-1 border-0" hidden="">
                                <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity" id="medicine_quantity_${
                                    index + 1
                                }" name="medicine_quantity[]" value="${
                        med_row.item_qty
                    }">
                            </td>

                            <td class="p-0 px-1 border-0">
                                ${selectInstructionElement}
                            </td>

                            <td class="p-0 px-1 border-0" style="width: 127%;">
                                <div class="input-group" style="width: 127%;">
                                <input type="text"
                                    class="form-control form-control-sm m-0 p-0 medicine_duration"
                                    id="medicine_duration_type_${index + 1}"
                                    name="medicine_duration_type[]"
                                    value="${med_row.duration}"
                                    ${med_row.continue_ind == 1 ? "disabled" : ""}>
                                ${selectDurationMuElement.replace(
                                    '<select',
                                    `<select ${med_row.continue_ind == 1 ? "disabled" : ""}`
                                )}
                            </div>
                            </td>

                            <td class="p-0 px-1 border-0 text-center">
                            <input type="checkbox" id="is_continue_${
                                index + 1
                            }" name="is_continue[]" onchange="prescriptionFunc.setContinueDuration(this)" value="${
                        med_row.continue_ind
                    }" ${med_row.continue_ind == 1 || med_row.duration == "Continue" ? "checked" : ""}>
                            </td>

                            <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_td_action_1">
                                <div class="btn-group" role="group" aria-label="Button group">
                                    <span class="btn btn-danger btn-md" onclick="removeTableRowOnly(this)">
                                        <i class="fa fa-times"></i>
                                    </span>
                                    <button type="button" class="btn btn-primary btn-md add-multidose ml-3"
                                            style="${
                                                doseNo > 1
                                                    ? "cursor: not-allowed; background-color: rgb(204, 204, 204); pointer-events: none;"
                                                    : ""
                                            }"
                                            onclick="prescriptionFunc.addMultiDoseRow(this)">
                                        <i class="fa fa-clone"></i>
                                    </button>
                                </div>
                            </td>
                         </tr>`;

                    let tableBody = $('#data-append-to').append($row);
                    //  $('#dose_'+(index + 1)).html(selectElement);
                    $(".select2").select2();
                    $('.select2').removeClass('select2-hidden-accessible');
                    $('.select2-container').remove();
                    // $('.select2').select2({
                    //     // placeholder: "Select Value",
                    //     allowClear: true
                    // });

                    // from here
                    $('.select2').select2({
                        tags: true, // Enable adding new options
                        placeholder: 'Select or type to add',
                        allowClear: true, // Allow clearing selection
                        templateResult: formatOption, // Format the display of options
                        templateSelection: formatOption // Format the selected option
                    });
                    // Function to format the options with data attributes
                    function formatOption(option) {
                        if (!option.id) {
                            return option.text; // Return the text if it's a new tag
                        }
                        const $option = $(
                            `<span>${option.text}</span>`
                        );
                        // Accessing custom data attributes
                        const dataQnty = $(option.element).data('qnty');
                        if (dataQnty !== undefined) {
                            $option.append(` (Qty: ${dataQnty})`);
                        }

                        return $option;
                    }

                    // added new here



                    //   }
                });

                previewTab();

            },
            complete: function(data) {
                $(thisElement).parents("tr").addClass("bg-success"); //bg-light-blue
                $.unblockUI();
            }
        });

    }

    function medicationUpdateLast(thisElement) {
        console.log('For Medicine')

        $(thisElement).parents("table").find("tr").removeClass("bg-success");
        var action = $(thisElement).attr("data-action");
        var disease_action = $(thisElement).attr("data-disease_action");
        var temp = $(thisElement).attr("data-temp");
        var hdn_su_no = $("#hdn_su_no").val();
        var app_id = $("#hdn_appointment_id").val();
        $(thisElement).parents("tr").addClass("bg-success");
        var prescription_id = $(thisElement).attr("data-presc");
        var dtls_action = $(thisElement).attr("data-dtls-action");
        var hdn_appointment_id = $("#hdn_appointment_id").val();

        // $.unblockUI();
        $.ajax({
            data: {
                hdn_su_no: hdn_su_no,
                hdn_appointment_id: hdn_appointment_id
            },
            url: dtls_action,
            type: "get",
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                console.log(response['pr_arr'])
                var doges = response['dose'];
                var route = response['route'];
                var duration = response['duration'];
                var instructions = response['instructions'];
                let pat_med_rs = response['pat_med_rs'];
                let meddurmu = response['meddurmu'];
                let cc_arr = response['cc_arr'];
                let ch_arr = response['ch_arr'];
                let icd_arr = response['icd_arr'];
                let lmp = response['lmp'];
                let in_arr = response['in_arr'];
                let inf_arr = response['inf_arr'];
                let find_arr = response['find_arr'];
                let adv_arr = response['ad_arr'];
                let pr_arr = response['pr_arr'];
                let acup_arr = response['acup_arr'];
                let ptet_arr = response['ptet_arr'];
                let ptte_arr = response['ptte_arr'];
                let duration_mu_phy = response['duration_mu_phy'];
                console.log(pr_arr + 'testing');
                // $("#data-append-to").html("");

                let tableBody = $('#data-append-to');
                // $('#data-append-to tr').not(':first').remove();
                $('#data-append-to tr').slice(1).remove();
                // var selectElement='';
                let medicineDoseCount = {};
                $.each(pat_med_rs, function(index, med_row) {
                    selectDoseElement =
                        `<div class="" id="doseID" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 medicine_dose doseEdit select2 select2-hidden-accessible" id="medicine_dose_${index + 1}" name="medicine_dose[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose'); prescriptionFunc.calculateMedicineQnty(this);" data-select2-id="medicine_dose_${index + 1}" tabindex="-1" aria-hidden="true"> <option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Route" data-input_label="Route" data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">Add More</option>`;
                    $.each(doges, function(key, value) {
                        console.log(value.data)
                        const isDoseSelected = med_row.dosage === value.data ?
                            `<option value="${value.data}" selected>${value.data}</option>` :
                            ` <option value="${value.data}">${value.data}</option>`;

                        const text_dose = med_row.dosage != value.data ?
                            `<option value="${med_row.dosage}" selected>${med_row.dosage}</option>` :
                            '';
                        // `<option value="0" selected>${med_row.dosage}</option>`
                        // med_row.dosage === value.data
                        selectDoseElement += isDoseSelected + text_dose;
                    });
                    selectDoseElement += `</select></div> <div class="editDosButton" id="medicine_dose_${index + 1}"
                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editDosButton');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option_dose"
                                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                                    data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 3px 5px 6px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div></div>`;

                    console.log(selectDoseElement)

                    selectRouteElement =
                        `<div class="" id="routeId" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 route_edit medicine_route select2 select2-hidden-accessible" id="medicine_route_${index + 1}" name="medicine_route[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');" data-select2-id="medicine_route_${index + 1}" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Route" data-input_label="Route" data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">Add More</option>`;
                    $.each(route, function(key, value) {
                        const isRouteSelected = med_row.route === value.data ? 'selected' :
                            '';
                        selectRouteElement +=
                            `<option value="${value.data}" ${isRouteSelected}>${value.data}</option>`

                    });
                    selectRouteElement += `</select> </div>
                                                <div class="editRouteValue" id="medicine_route_${index + 1}"
                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editRouteValue');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option_route"
                                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 3px 5px 6px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div>
                                            </div>`;

                    selectInstructionElement =
                        `<div class="" id="instructionId" style="display: flex">
                                                <div style="width:100%;"><select class="form-control form-control-sm m-0 p-0 instructionEdit medicine_instruction select2 select2-hidden-accessible" id="instruction_${index + 1}" name="instruction[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');" data-select2-id="instruction_${index + 1}" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Instruction" data-input_label="Instruction" data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal ...)" value="0">Add More</option>`;
                    $.each(instructions, function(key, value) {
                        const isInstructionSelected = med_row.instruction_take === value
                            .data ? 'selected' : '';
                        selectInstructionElement +=
                            `<option value="${value.data}" ${isInstructionSelected}>${value.data}</option>`

                    });
                    selectInstructionElement += `</select></div style="width:100%;">
                                                <div class="editInsButton" id="instruction_${index + 1}"

                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editInsButton');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option"
                                                    data-popup_header="Medicine Instruction"
                                                    data-input_label="Instruction"
                                                    data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal..)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 3px 5px 6px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div>
                                            </div>`;

                    selectDurationElement =
                        `<select class="form-control form-control-sm m-0 p-0 medicine_instruction select2 select2-hidden-accessible" id="instruction_${index + 1}" name="instruction[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');" data-select2-id="instruction_${index + 1}" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Instruction" data-input_label="Instruction" data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal ...)" value="0">Add More</option>`;
                    $.each(duration, function(key, value) {
                        const isDurationSelected = med_row.duration === value.data ?
                            'selected' : '';
                        selectDurationElement +=
                            `<option value="${value.data}" ${isDurationSelected}>${value.data}</option>`

                    });
                    selectDurationElement += `</select>`;

                    selectDurationMuElement =
                        `<select class="form-control medicine_duration_mu" id="medicine_duration_mu_${index + 1}" name="medicine_duration_mu[]" >`;
                    $.each(meddurmu, function(key, value) {
                        // const isDurationMuSelected = med_row.duration_mu == value.data
                        //     .toUpperCase() ? 'selected' : '';
                        const isDurationMuSelected =
                        med_row.duration_mu?.trim().toUpperCase() === value.data?.trim().toUpperCase()
                            ? "selected"
                            : "";


                        selectDurationMuElement +=
                            `<option value="${value.data}" ${isDurationMuSelected}>${value.data}</option>`

                    });
                    selectDurationMuElement += `</select>`;

                    // if (med_row.item_no_fk > 0) {


                    // Initialize medicineDoseCount if it doesn't exist
                    // window.medicineDoseCount = window.medicineDoseCount || {};
                    // var medicineItem = med_row.brand_name || 'Unknown';
                    // var itemId = med_row.item_no_fk || 0;
                    // var doseNo = 0;
                    // var itemIdStr = String(itemId);
                    // window.medicineDoseCount[itemIdStr] = (window.medicineDoseCount[itemIdStr] || 0) + 1;
                    // doseNo = window.medicineDoseCount[itemIdStr];
                    // if (doseNo > 0) {
                    //     console.log('Dose number for item ID ' + itemId + ' is: ' + doseNo);
                    //     console.log('Item Name: ' + medicineItem);
                    // } else {
                    //     console.log('No doses to process for item ID ' + itemId + '.');
                    // }
                    const medicineItem = med_row.brand_name ?
                        med_row.brand_name.trim() :
                        "Unknown";
                    const itemId = med_row.item_no_fk || 0;
                    const generic_name = med_row && med_row.generic_name ? med_row.generic_name :
                        '';

                    // Clean the brand name (remove spaces, lowercase)
                    const normalizedName = medicineItem
                        .toLowerCase()
                        .replace(/\s+/g, "");

                    // Unique key: itemId + brandName
                    const doseKey = `${itemId}_${normalizedName}`;

                    // Initialize count if not exist
                    if (!medicineDoseCount[doseKey]) {
                        medicineDoseCount[doseKey] = 0;
                    }

                    // Increment dose number
                    medicineDoseCount[doseKey]++;
                    const doseNo = medicineDoseCount[doseKey];

                    let $row = `<tr class="border-0" id="tr_id_${index + 1}">


                             <td class="p-0 px-1 border-0" width="20%">
                                ${
                                    doseNo === 1
                                        ? `
                                    <input type="text"
                                        class="form-control form-control-sm m-0 p-0 item_element bg-white"
                                        id="medicine_item_${index + 1}" name="medicine_item[]"
                                        placeholder="Generic / Brand" value="${medicineItem}"
                                        style="border: 0px none;" readonly="readonly">`
                                        : ""
                                }

                                <input type="hidden" id="hdn_medicine_item_id_${index + 1}"
                                    name="hdn_medicine_item_id[]" value="${itemId}">
                                    <input type="hidden" id="hdn_genetic_id_${index + 1}"
                                        name="hdn_genetic_id[]" value="${generic_name}">
                                <input type="hidden" id="hdn_report_serial_med_${index + 1}"
                                    name="hdn_report_serial_med[]" value="1">

                                <input type="hidden" id="hidden_multidose_id_${index + 1}"
                                    name="multidose[]" value="${med_row.multidose_txt}">

                                ${
                                    doseNo > 1
                                        ? `
                                    <input type="hidden"
                                        class="form-control form-control-sm m-0 p-0 item_element bg-white"
                                        id="medicine_item_${index + 1}" name="medicine_item[]"
                                        placeholder="Generic / Brand" value="${medicineItem}"
                                        style="border: 0px none;" readonly="readonly">

                                    <span class="dose-id-display"
                                        style="color: #262323; background-color: rgb(221 164 152 / 18%); padding: 3px 15px; border-radius: 8px; font-weight: bold; display: inline-block; width: 100%; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Dose No: ${doseNo}
                                    </span>
                                    `
                                        : ""
                                }
                            </td>



                            <td class="p-0 border-0" id="alternative_id_${
                                index + 1
                            }" style="vertical-align: top;">


                            </td>

                            <td class="p-0 border-0" id="med_favourit_${
                                index + 1
                            }" style="vertical-align: top;">
                               <span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionV2.addToPresFavouritListV2(this, '#pres-favourit-list-med')" data-url="http://localhost/Nextgen/h360/public/add-pres-favourit-list" data-id="${med_row.item_no_fk}" data-name="${med_row.brand_name}" data-type="MED" data-duration="${med_row.duration}" data-route="${med_row.route}" data-dose="${med_row.dosage}" data-quantity="${med_row.quantity}" data-continue="${med_row.is_continue}" data-instruction="${med_row.instruction}" data-duration-type="${med_row.duration_type}"><i class="fa fa-star text-primary"></i></span>
                            </td>

                            <td class="p-0 px-1 border-0">
                              ${selectDoseElement}
                            </td>

                            <td class="p-0 px-1 border-0">
                              ${selectRouteElement}
                            </td>

                            <td class="p-0 px-1 border-0" hidden="">
                                <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity" id="medicine_quantity_${
                                    index + 1
                                }" name="medicine_quantity[]" value="${
                        med_row.item_qty
                    }">
                            </td>

                            <td class="p-0 px-1 border-0">
                                ${selectInstructionElement}
                            </td>

                            <td class="p-0 px-1 border-0" style="width: 127%;">
                              <div class="input-group" style="width: 127%;">
                                <input type="text"
                                    class="form-control form-control-sm m-0 p-0 medicine_duration"
                                    id="medicine_duration_type_${index + 1}"
                                    name="medicine_duration_type[]"
                                    value="${med_row.duration}"
                                    ${med_row.continue_ind == 1 ? "disabled" : ""}>
                                ${selectDurationMuElement.replace(
                                    '<select',
                                    `<select ${med_row.continue_ind == 1 ? "disabled" : ""}`
                                )}
                            </div>
                            </td>

                            <td class="p-0 px-1 border-0 text-center">
                            <input type="checkbox" id="is_continue_${
                                index + 1
                            }" name="is_continue[]" onchange="prescriptionFunc.setContinueDuration(this)" value="${
                        med_row.continue_ind
                    }" ${med_row.continue_ind == 1 || med_row.duration == "Continue" ? "checked" : ""}>
                            </td>

                            <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_td_action_1">
                                <div class="btn-group" role="group" aria-label="Button group">
                                    <span class="btn btn-danger btn-md" onclick="removeTableRowOnly(this)">
                                        <i class="fa fa-times"></i>
                                    </span>
                                    <button type="button" class="btn btn-primary btn-md add-multidose ml-3"
                                            style="${
                                                doseNo > 1
                                                    ? "cursor: not-allowed; background-color: rgb(204, 204, 204); pointer-events: none;"
                                                    : ""
                                            }"
                                            onclick="prescriptionFunc.addMultiDoseRow(this)">
                                        <i class="fa fa-clone"></i>
                                    </button>
                                </div>
                            </td>
                         </tr>`;

                    let tableBody = $('#data-append-to').append($row);
                    //  $('#dose_'+(index + 1)).html(selectElement);
                    $(".select2").select2();
                    $('.select2').removeClass('select2-hidden-accessible');
                    $('.select2-container').remove();
                    // $('.select2').select2({
                    //     // placeholder: "Select Value",
                    //     allowClear: true
                    // });

                    // from here
                    $('.select2').select2({
                        tags: true, // Enable adding new options
                        placeholder: 'Select or type to add',
                        allowClear: true, // Allow clearing selection
                        templateResult: formatOption, // Format the display of options
                        templateSelection: formatOption // Format the selected option
                    });
                    // Function to format the options with data attributes
                    function formatOption(option) {
                        if (!option.id) {
                            return option.text; // Return the text if it's a new tag
                        }
                        const $option = $(
                            `<span>${option.text}</span>`
                        );
                        // Accessing custom data attributes
                        const dataQnty = $(option.element).data('qnty');
                        if (dataQnty !== undefined) {
                            $option.append(` (Qty: ${dataQnty})`);
                        }

                        return $option;
                    }

                    // added new here



                    //   }
                });

                previewTab();

            },
            complete: function(data) {
                $(thisElement).parents("tr").addClass("bg-success"); //bg-light-blue
                $.unblockUI();
            }
        });

    }
</script>
