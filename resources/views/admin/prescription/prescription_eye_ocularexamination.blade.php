<link rel="stylesheet" href="{{ asset('select2/dist/css/select2.min.css') }}">
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="form-row border-top">
    <div class="col-md-6 bg-light-blue"><strong>Right Eye</strong></div>
    <div class="col-md-6 bg-light-blue border-left"><strong>Left Eye</strong></div>
    <div class="col border-top">
        <div class="form-group">
            {{-- @dd($eye_ocular_arr, $ocular_exam_right_arr) --}}
            <label for="procedure_item" class="col-form-label col-form-label-sm">VA(UA)</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            {{-- @dd($eye_ocular_arr->VAUA) --}}
            <select class="form-control occu_exam_element vaua" id="vaua_VAUA" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.vaua');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                        data-popup_header="VA(UA)" data-input_label="VA(UA)"
                        data-input_placeholder="Enter VA(UA) (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->VAUA))
                    @foreach ($eye_ocular_arr->VAUA as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id]) ? "selected='selected'" : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }} {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}
                        </option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" id="item_name" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="VAUA" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>

        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">VA(PH)</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element vaph" id="vaph_VAPH" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.vaph');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                        data-popup_header="VA(PH)" data-input_label="VA(PH)"
                        data-input_placeholder="Enter VA(PH) (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr))
                    @foreach ($eye_ocular_arr->VAPH as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" id="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="VAPH" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">VA(GLASS)</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element vaglass" id="vaglass_VAGLASS" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.vaglass');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                    data-popup_header="VA(GLASS)" data-input_label="VA(GLASS)"
                    data-input_placeholder="Enter VA(GLASS) (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->VAGLASS))
                    @foreach ($eye_ocular_arr->VAGLASS as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="VAGLASS" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">EyeLid</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element eyelid" id="eyelid_EYELID" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.eyelid');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="EYELID" data-input_label="EYELID"
                data-input_placeholder="Enter EYELID (Ocular)" value="0">Add More
            </option>
                @if (!empty($eye_ocular_arr->EYELID))
                    @foreach ($eye_ocular_arr->EYELID as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="EYELID" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">EyeLash</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element eyelash" id="eyelash_EYELASH" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.eyelash');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="EYELASH" data-input_label="EYELASH"
                data-input_placeholder="Enter EYELASH (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->EYELASH))
                    @foreach ($eye_ocular_arr->EYELASH as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="EYELASH" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Cornea</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element cornea" id="cornea_CORNEA" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.cornea');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="CORNEA" data-input_label="CORNEA"
                data-input_placeholder="Enter CORNEA (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->CORNEA))
                    @foreach ($eye_ocular_arr->CORNEA as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="CORNEA" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Conjunctiva & Fornices</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element conjunctivafornices" id="conjunctivafornices_CONJUNCTIVAFORNICES" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.conjunctivafornices');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="CONJUNCTIVAFORNICES" data-input_label="CONJUNCTIVAFORNICES"
                data-input_placeholder="Enter CONJUNCTIVAFORNICES (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->CONJUNCTIVAFORNICES))
                    @foreach ($eye_ocular_arr->CONJUNCTIVAFORNICES as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="CONJUNCTIVAFORNICES" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">A/C</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element ac" id="ac_AC" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.ac');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="AC" data-input_label="AC"
                data-input_placeholder="Enter AC (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->AC))
                    @foreach ($eye_ocular_arr->AC as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="AC" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Pupil</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element pupil" id="pupil_PUPIL" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.pupil');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="PUPIL" data-input_label="PUPIL"
                data-input_placeholder="Enter PUPIL (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->PUPIL))
                    @foreach ($eye_ocular_arr->PUPIL as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="PUPIL" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Iris</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element iris" id="iris_IRIS" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.iris');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="IRIS" data-input_label="IRIS"
                data-input_placeholder="Enter IRIS (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->IRIS))
                    @foreach ($eye_ocular_arr->IRIS as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="IRIS" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Lens</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element lens" id="lens_LENS" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.lens');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="LENS" data-input_label="LENS"
                data-input_placeholder="Enter LENS (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->LENS))
                    @foreach ($eye_ocular_arr->LENS as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="LENS" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
    </div>
    <div class="col border-top border-right">
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Retina</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element retina" id="retina_RETINA" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.retina');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="RETINA" data-input_label="RETINA"
                data-input_placeholder="Enter RETINA (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->RETINA))
                    @foreach ($eye_ocular_arr->RETINA as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="RETINA" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Vitreous</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element vitreous" id="vitreous_VITREOUS" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.vitreous');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="VITREOUS" data-input_label="VITREOUS"
                data-input_placeholder="Enter VITREOUS (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->VITREOUS))
                    @foreach ($eye_ocular_arr->VITREOUS as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="VITREOUS" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Occular Motility</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element occularmotility" id="occularmotility_OCCULARMOTILITY" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.occularmotility');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="OCCULARMOTILITY" data-input_label="OCCULARMOTILITY"
                data-input_placeholder="Enter OCCULARMOTILITY (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->OCCULARMOTILITY))
                    @foreach ($eye_ocular_arr->OCCULARMOTILITY as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="OCCULARMOTILITY" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">IOP</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element iop" id="iop_IOP" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.iop');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="IOP" data-input_label="IOP"
                data-input_placeholder="Enter IOP (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->IOP))
                    @foreach ($eye_ocular_arr->IOP as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="IOP" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Sclera</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element sclera" id="sclera_SCLERA" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.sclera');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="SCLERA" data-input_label="SCLERA"
                data-input_placeholder="Enter SCLERA (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->SCLERA))
                    @foreach ($eye_ocular_arr->SCLERA as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="SCLERA" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Choroid</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element choroid" id="choroid_CHOROID" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.choroid');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="CHOROID" data-input_label="CHOROID"
                data-input_placeholder="Enter CHOROID (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->CHOROID))
                    @foreach ($eye_ocular_arr->CHOROID as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="CHOROID" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>

        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Optic Nerve</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element opticnerve" id="opticnerve_OPTICNERVE" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.opticnerve');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="OPTICNERVE" data-input_label="OPTICNERVE"
                data-input_placeholder="Enter OPTICNERVE (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->OPTICNERVE))
                    @foreach ($eye_ocular_arr->OPTICNERVE as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="OPTICNERVE" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">C:D</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element cd" id="cd_CD" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.cd');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="CD" data-input_label="CD"
                data-input_placeholder="Enter CD (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->CD))
                    @foreach ($eye_ocular_arr->CD as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="CD" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Anterior Segment</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element anteriorsegment" id="anteriorsegment_ANTERIORSEGMENT" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.anteriorsegment');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="ANTERIORSEGMENT" data-input_label="ANTERIORSEGMENT"
                data-input_placeholder="Enter ANTERIORSEGMENT (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->ANTERIORSEGMENT))
                    @foreach ($eye_ocular_arr->ANTERIORSEGMENT as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="ANTERIORSEGMENT" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Posterior Segment</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element posteriorsegment" id="posteriorsegment_POSTERIORSEGMENT" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.posteriorsegment');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="POSTERIORSEGMENT" data-input_label="POSTERIORSEGMENT"
                data-input_placeholder="Enter POSTERIORSEGMENT (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->POSTERIORSEGMENT))
                    @foreach ($eye_ocular_arr->POSTERIORSEGMENT as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="POSTERIORSEGMENT" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">N5</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element n5" id="n5_N5" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.n5');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="N5" data-input_label="N5"
                data-input_placeholder="Enter N5 (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->N5))
                    @foreach ($eye_ocular_arr->N5 as $eye_row)
                        @php
                            $selected = isset($ocular_exam_right_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_right_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="N5" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="R" readonly="readonly">
        </div>
    </div>
    <div class="col border-top">
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">VA(UA)</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element vaual" id="vaual_VAUA" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.vaual');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="VAUA" data-input_label="VAUA"
                data-input_placeholder="Enter VAUA (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->VAUA))
                    @foreach ($eye_ocular_arr->VAUA as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}
                            {{ $selected }}>{{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="VAUA" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">VA(PH)</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element vaphl" id="vaphl_VAPH"  onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.vaphl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="VAPH" data-input_label="VAPH"
                data-input_placeholder="Enter VAPH (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->VAPH))
                    @foreach ($eye_ocular_arr->VAPH as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="VAPH" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">VA(GLASS)</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element vaglassl" id="vaglassl_VAGLASS" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.vaglassl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="VAGLASS" data-input_label="VAGLASS"
                data-input_placeholder="Enter VAGLASS (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->VAGLASS))
                    @foreach ($eye_ocular_arr->VAGLASS as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="VAGLASS" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">EyeLid</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element eyelidl" id="eyelidl_EYELID" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.eyelidl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="EYELID" data-input_label="EYELID"
                data-input_placeholder="Enter EYELID (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->EYELID))
                    @foreach ($eye_ocular_arr->EYELID as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="EYELID" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">EyeLash</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element eyelashl" id="eyelashl_EYELASH" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.eyelashl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="EYELASH" data-input_label="EYELASH"
                data-input_placeholder="Enter EYELASH (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->EYELASH))
                    @foreach ($eye_ocular_arr->EYELASH as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="EYELASH" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Cornea</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element corneal" id="corneal_CORNEA" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.corneal');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="CORNEA" data-input_label="CORNEA"
                data-input_placeholder="Enter CORNEA (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->CORNEA))
                    @foreach ($eye_ocular_arr->CORNEA as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="CORNEA" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Conjunctiva & Fornices</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element conjunctivafornicesl" id="conjunctivafornicesl_CONJUNCTIVAFORNICES" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.conjunctivafornicesl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="CONJUNCTIVAFORNICES" data-input_label="CONJUNCTIVAFORNICES"
                data-input_placeholder="Enter CONJUNCTIVAFORNICES (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->CONJUNCTIVAFORNICES))
                    @foreach ($eye_ocular_arr->CONJUNCTIVAFORNICES as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="CONJUNCTIVAFORNICES" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">A/C</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element acl" id="acl_AC" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.acl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="AC" data-input_label="AC"
                data-input_placeholder="Enter AC (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->AC))
                    @foreach ($eye_ocular_arr->AC as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="AC" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Pupil</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element pupill" id="pupill_PUPIL" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.pupill');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="PUPIL" data-input_label="PUPIL"
                data-input_placeholder="Enter PUPIL (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->PUPIL))
                    @foreach ($eye_ocular_arr->PUPIL as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="PUPIL" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Iris</label>
            <select class="form-control occu_exam_element irisl" id="irisl_IRIS" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.irisl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="IRIS" data-input_label="IRIS"
                data-input_placeholder="Enter IRIS (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->IRIS))
                    @foreach ($eye_ocular_arr->IRIS as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="" readonly="readonly">
            <input type="hidden" name="item_name[]" value="" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="IRIS" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Lens</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element lensl" id="lensl_LENS" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.lensl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="LENS" data-input_label="LENS"
                data-input_placeholder="Enter LENS (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->LENS))
                    @foreach ($eye_ocular_arr->LENS as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="LENS" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
    </div>
    <div class="col border-top">
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Retina</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element retinal" id="retinal_RETINA" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.retinal');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="RETINA" data-input_label="RETINA"
                data-input_placeholder="Enter RETINA (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->RETINA))
                    @foreach ($eye_ocular_arr->RETINA as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="RETINA" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Vitreous</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element vitreousl" id="vitreousl_VITREOUS" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.vitreousl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="VITREOUS" data-input_label="VITREOUS"
                data-input_placeholder="Enter VITREOUS (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->VITREOUS))
                    @foreach ($eye_ocular_arr->VITREOUS as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="VITREOUS" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Occular Motility</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element occularmotilityl" id="occularmotilityl_OCCULARMOTILITY" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.occularmotilityl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="OCCULARMOTILITY" data-input_label="OCCULARMOTILITY"
                data-input_placeholder="Enter OCCULARMOTILITY (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->OCCULARMOTILITY))
                    @foreach ($eye_ocular_arr->OCCULARMOTILITY as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="OCCULARMOTILITY" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">IOP</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element iopl" id="iopl_IOP" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.iopl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="IOP" data-input_label="IOP"
                data-input_placeholder="Enter IOP (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->IOP))
                    @foreach ($eye_ocular_arr->IOP as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="IOP" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Sclera</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element scleral" id="scleral_SCLERA" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.scleral');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="retina" data-input_label="retina"
                data-input_placeholder="Enter retina (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->SCLERA))
                    @foreach ($eye_ocular_arr->SCLERA as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="SCLERA" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Choroid</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element choroidl" id="choroidl_CHOROID" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.choroidl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="CHOROID" data-input_label="CHOROID"
                data-input_placeholder="Enter CHOROID (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->CHOROID))
                    @foreach ($eye_ocular_arr->CHOROID as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="CHOROID" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Optic Nerve</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element opticnervel" id="opticnervel_OPTICNERVE" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.opticnervel');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="OPTICNERVE" data-input_label="OPTICNERVE"
                data-input_placeholder="Enter OPTICNERVE (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->OPTICNERVE))
                    @foreach ($eye_ocular_arr->OPTICNERVE as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="OPTICNERVE" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">C:D</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element cdl" id="cdl_CD" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.cdl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="CD" data-input_label="CD"
                data-input_placeholder="Enter CD (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->CD))
                    @foreach ($eye_ocular_arr->CD as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="CD" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Anterior Segment</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element anteriorsegmentl" id="anteriorsegmentl_ANTERIORSEGMENT" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.anteriorsegmentl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="ANTERIORSEGMENT" data-input_label="ANTERIORSEGMENT"
                data-input_placeholder="Enter ANTERIORSEGMENT (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->ANTERIORSEGMENT))
                    @foreach ($eye_ocular_arr->ANTERIORSEGMENT as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="ANTERIORSEGMENT" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">Posterior Segment</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element posteriorsegmentl" id="posteriorsegmentl_POSTERIORSEGMENT" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.posteriorsegmentl');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="POSTERIORSEGMENT" data-input_label="POSTERIORSEGMENT"
                data-input_placeholder="Enter POSTERIORSEGMENT (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->POSTERIORSEGMENT))
                    @foreach ($eye_ocular_arr->POSTERIORSEGMENT as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="POSTERIORSEGMENT" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="procedure_item" class="col-form-label col-form-label-sm">N5</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element n5l" id="n5l_N5" onchange="prescriptionFunc.selectOccuExamElements(this);prescriptionFunc.addMoreDropdownOptionEMON(this,'.n5l');">
                <option value="0">Select</option>
                <option data-qnty="0" data-dropdown_option="add_more"
                data-popup_header="N5" data-input_label="N5"
                data-input_placeholder="Enter N5 (Ocular)" value="0">Add More
                </option>
                @if (!empty($eye_ocular_arr->N5))
                    @foreach ($eye_ocular_arr->N5 as $eye_row)
                        @php
                            $selected = isset($ocular_exam_left_arr[$eye_row->lookupdata_id])
                                ? "selected='selected'"
                                : '';
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_id = $eye_row->lookupdata_id;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $item_name = $eye_row->lookupdata_name;
                            }

                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookupdata_code = $eye_row->lookupdata_uid;
                            }
                            if (isset($ocular_exam_left_arr[$eye_row->lookupdata_id])) {
                                $lookup_id = $eye_row->lookup_id;
                            }
                        @endphp
                        <option value="{{ $eye_row->lookupdata_id }}" data-lkp-id="{{ $eye_row->lookup_id }}"
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
            <input type="hidden" name="lookup_id[]" value="{{ $lookup_id }}" readonly="readonly">
            <input type="hidden" name="lookup_code[]" value="N5" readonly="readonly">
            <input type="hidden" name="lookupdata_code[]" value="{{ $lookupdata_code }}" readonly="readonly">
            <input type="hidden" name="ocular_position[]" value="L" readonly="readonly">
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('select2/dist/js/select2.min.js') }}"></script>
<script>
    // $(".occu_exam_element").select2();
</script>
