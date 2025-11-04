@php

$patient_type = isset($data) && !empty($data) ? $data : [];

$patient_type_code = $patient_type ? $patient_type->patient_type_code : '';
$patient_type_desc = $patient_type ? $patient_type->patient_type_desc : '';
$status = $patient_type ? $patient_type->status : '';
$discountpolicy_no_fk = $patient_type ? $patient_type->discountpolicy_no_fk : '';
$patient_type_no_pk = $patient_type ? $patient_type->patient_type_no_pk : '';

@endphp





<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form action="{{ route('store-patient-type') }}" method="post" id="patient_type_form">
            @csrf
            <input type="hidden" name="id" value="{{ $patient_type_no_pk }}">
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="patient_type_code" class="col-form-label col-form-label-sm">Patient Type Code<span
                            class="text-danger">*</span></label>

                    <input type="text" class="form-control form-control-sm" id="patient_type_code"
                        value="{{ $patient_type_code }}" name="patient_type_code" value=""
                        placeholder="Enter Patient Type Code" required>
                </div>
            </div>

            <div class="form-group row">

                <div class="col-md-12">
                    <label for="patient_type_description" class="col-form-label col-form-label-sm">Patient Type
                        Description <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm " id="patient_type_description"
                        name="patient_type_description" value="{{ $patient_type_desc }}"
                        placeholder="Enter Patient Type Description" required>
                </div>
            </div>

            <div class="form-group row">

                <div class="col-md-12">
                    <label for="discount_policy" class="">Discount Policy <span
                            class="text-danger">*</span></label>
                    <div class="">
                        <select class="form-control font_size_12 m-auto" id="discount_policy" name="discount_policy"
                            required>
                            <option selected="selected" value="">Select Discount Policy</option>
                            @foreach ($discountPolicy as $record)
                                <option value="{{ $record->discountpolicy_no_pk }}"
                                    {{ $record->discountpolicy_no_pk == $discountpolicy_no_fk ? 'selected' : '' }}>
                                    {{ $record->discount_name }}(<strong>{{ $record->maximum_percent }}%</strong>)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row">

                <div class="col-md-12">
                    <label for="status" class="">Status</label>
                    <div class="">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
                                {{ $status == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </div>
                </div>
            </div>



            @php
                $response_action = route('patient-type');
            @endphp

            <div class="text-left">
                <button type="submit" class="btn btn-md btn-success"
                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                    Save
                </button>
                <button type="reset" class="btn btn-md btn-info " data-dismiss="modal">Clear</button>
                <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button>
            </div>
        </form>
    </div>
</div>
