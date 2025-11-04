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
            <label for="procedure_item" class="col-form-label col-form-label-sm">VA(UA)</label>
            @php
                $lookupdata_code = '';
                $item_id = '';
                $item_name = '';
                $lookup_id = '';
            @endphp
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
                @if (!empty($eye_ocular_arr->VAUA))
                    @foreach ($eye_ocular_arr->VAUA as $eye_row)
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
                            data-lkpdatacode="{{ $eye_row->lookupdata_uid }}" {{ $selected }} {{ $selected }}>
                            {{ $eye_row->lookupdata_name }}</option>
                    @endforeach
                @endif
            </select>

            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
            <input type="hidden" name="item_name[]" value="{{ $item_name }}" readonly="readonly">
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <input type="hidden" name="item_id[]" value="{{ $item_id }}" readonly="readonly">
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
            <select class="form-control occu_exam_element" onchange="prescriptionFunc.selectOccuExamElements(this)">
                <option value="0">Select</option>
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
    $(".occu_exam_element").select2();
</script>
