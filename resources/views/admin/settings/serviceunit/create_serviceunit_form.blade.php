@php
    $serviceunit = isset($serviceunit) && !empty($serviceunit) ? $serviceunit : [];

    $id = $serviceunit ? $serviceunit->serviceunit_no_pk : '';
    $serviceunit_code = $serviceunit ? $serviceunit->serviceunit_code : '';
    $serviceunit_no_parent_fk = $serviceunit ? $serviceunit->serviceunit_no_parent_fk : '';
    $serviceunit_name = $serviceunit ? $serviceunit->serviceunit_name : '';
    $report_header = $serviceunit ? $serviceunit->report_header : '';
    $serviceunit_hod_person_no_fk = $serviceunit ? $serviceunit->serviceunit_hod_person_no_fk : '';
    $clinical_ind = $serviceunit ? $serviceunit->clinical_ind : '';
    $med_store_ind = $serviceunit ? $serviceunit->med_store_ind : '';
    $radiology_ind = $serviceunit ? $serviceunit->radiology_ind : '';
    $pathology_ind = $serviceunit ? $serviceunit->pathology_ind : '';
    $ipd_ind = $serviceunit ? $serviceunit->ipd_ind : '';
    $ot_ind = $serviceunit ? $serviceunit->ot_ind : '';
    $dental_ind = $serviceunit ? $serviceunit->dental_ind : '';
    $eye_ind = $serviceunit ? $serviceunit->eye_ind : '';
    $pharmacy_ind = $serviceunit ? $serviceunit->pharmacy_ind : '';
    $lp_ind = $serviceunit ? $serviceunit->lp_ind : '';
    $hospital_store_ind = $serviceunit ? $serviceunit->hospital_store_ind : '';
    $pta_ind = $serviceunit ? $serviceunit->pta_ind : '';
    $physio_ind = $serviceunit ? $serviceunit->physio_ind : '';
    $hk_ind = $serviceunit ? $serviceunit->hk_ind : '';

    $cash_counter_ind = $serviceunit ? $serviceunit->cash_counter_ind : '';
    $duty_area_ind = $serviceunit ? $serviceunit->duty_area_ind : '';
    $external_hosp_su_ind = $serviceunit ? $serviceunit->external_hosp_su_ind : '';
    $main_ind = $serviceunit ? $serviceunit->main_store_ind : '';
    $sub_store_ind = $serviceunit ? $serviceunit->sub_store_ind : '';
    $pos = $serviceunit ? $serviceunit->hs_pos_ind : '';
    $asset_store = $serviceunit ? $serviceunit->asset_ind : '';
    $asset_sub_store = $serviceunit ? $serviceunit->asset_sub_store_ind : '';
    $hr_unit_ind = $serviceunit ? $serviceunit->hr_unit_ind : '';
    $hr_dept_ind = $serviceunit ? $serviceunit->hr_dept_ind : '';
    $status = $serviceunit ? $serviceunit->status : '';
    $sl_no = $serviceunit ? $serviceunit->sl_no : '';
    $emergency_daycare_ind_txt = $serviceunit ? $serviceunit->emergency_daycare_ind_txt : '';
    //  dd($emergency_daycare_ind_txt);
@endphp
<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('serviceunit.store') }}" method="post" id="serviceunit-create">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Service Unit ID <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="service_unit_id" name="service_unit_id"
                    value="{{ $serviceunit_code }}" placeholder="Enter Service Unit ID" required>
                <span class="focus_input"></span>
            </div>

            <label for="parent_service_unit" class="col-sm-12 col-form-label col-form-label-sm">Parent Service
                Unit</label>
            <div class="col-sm-12">
                <select class="form-control font_size_12 m-auto" id="parent_service_unit" name="parent_service_unit"
                    required>
                    <option value="0">Select Parent Service</option>
                    @if (isset($serviceunit_data) && $serviceunit_data->count() > 0)
                        @foreach ($serviceunit_data as $key => $value)
                            <option value="{{ $value->serviceunit_no_pk }}"
                                {{ $serviceunit_no_parent_fk == $value->serviceunit_no_pk ? 'selected' : '' }}>
                                {{ $value->serviceunit_name }}</option>
                        @endforeach
                    @endif
                </select>
                <span class="focus_input"></span>
            </div>
        </div>

        <div class="form-group row">
            <label for="service_name" class="col-sm-12 col-form-label col-form-label-sm">Service Name <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="service_name" name="service_name"
                    value="{{ $serviceunit_name }}" placeholder="Enter Service Name" required>
                <span class="focus_input"></span>
            </div>

            <label for="service_report_header" class="col-sm-12 col-form-label col-form-label-sm">Report Header</label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="service_report_header"
                    name="service_report_header" value="{{ $report_header }}" placeholder="Enter Report Header">
                <span class="focus_input"></span>
            </div>
        </div>
        <div class="form-group row">
            <label for="service_unit_hod" class="col-sm-12 col-form-label col-form-label-sm">Service Unit HoD </label>
            <div class="col-sm-12">
                <input type="number" class="form-control form-control-sm" id="service_unit_hod" name="service_unit_hod"
                    value="{{ $serviceunit_hod_person_no_fk }}" placeholder="Enter Service Unit HoD">
                <span class="focus_input"></span>
            </div>
        </div>
        <div class="form-group row">
            <label for="sl_no" class="col-sm-12 col-form-label col-form-label-sm">Ordering Serial No </label>
            <div class="col-sm-12">
                <input type="number" class="form-control form-control-sm" id="sl_no" name="sl_no"
                    value="{{ $sl_no }}" placeholder="Enter SL NO">
                <span class="focus_input"></span>
            </div>
        </div>
        <div class="form-group row">
            <label for="module_type" class="col-sm-12 col-form-label col-form-label-sm">Bed Dept. Text</label>
            <div class="col-sm-12">
                {{-- <select class="form-control font_size_12 m-auto" id="module_type" name="module_type">
                    <option value="0">Select Bed Dept. Text</option>
                    <option value="Emergency"  {{ $emergency_daycare_ind_txt == "Emergency" ? 'selected' : '' }}>Emergency</option>
                    <option value="Day Care"  {{ $emergency_daycare_ind_txt == "Day Care" ? 'selected' : '' }}>Day Care</option>
                    <option value="Dialysis"  {{ $emergency_daycare_ind_txt == "Dialysis" ? 'selected' : '' }}>Dialysis</option>
                </select> --}}

                {{-- {{dd($emergency_daycare_ind_txt,$bedtextind)}} --}}
                <select class="form-control font_size_12 m-auto" id="module_type" name="module_type">
                    <option value="0">Select Bed Dept. Text</option>
                    @if (!empty($bedtextind))
                        @foreach ($bedtextind as $pk => $bedtext)
                            <option value="{{ $bedtext }}"
                                {{ $emergency_daycare_ind_txt == $bedtext ? 'selected' : '' }}>{{ $bedtext }}
                            </option>
                        @endforeach
                    @endif
                </select>
                <span class="focus_input"></span>
            </div>
        </div>
        <!-- 	<div class="form-group row">
   <label for="clinical_status" class="col-sm-12 col-form-label col-form-label-sm">Clinical</label>
   <div class="col-sm-12">
    <div class="form-check form-check-inline">
     <input class="form-check-input" type="checkbox" name="clinical_status" id="clinical_status" value="1" {{ $clinical_ind == '1' ? 'checked' : '' }}>
     <label class="form-check-label" for="clinical_status">Clinical</label>
   </div>
   </div>
   <label for="status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
   <div class="col-sm-12">
    <div class="form-check form-check-inline">
     <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $status == '1' ? 'checked' : '' }} >
     <label class="form-check-label" for="status">Active</label>
   </div>
   </div>
  </div> -->

        <div class="form-row">
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="clinical_status" id="clinical_status"
                        value="1" {{ $clinical_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="clinical_status">Clinical</label>
                </div>

            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="medicine_status" id="medicine_store"
                        value="1" {{ $med_store_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="medicine_store">Medicine Store</label>
                </div>

            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="pharmacy_status" id="pharmacy_store"
                        value="1" {{ $pharmacy_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="pharmacy_store">Pharmacy Store</label>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hospital_status" id="hospital_store"
                        value="1" {{ $hospital_store_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="hospital_store">Hospital Store</label>
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="lp_store" id="lp_store" value="1"
                        {{ $lp_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="lp_store">LP Store</label>
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="pathology_status" id="pathology"
                        value="1" {{ $pathology_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="pathology">Pathology</label>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="radiology_status" id="radiology"
                        value="1" {{ $radiology_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="radiology">Radiology</label>
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="ipd_status" id="ipd_status"
                        value="1" {{ $ipd_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="ipd_status">IPD</label>
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="ot_status" id="ot_status" value="1"
                        {{ $ot_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="ot_status">OT</label>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="dental_status" id="dental_status"
                        value="1" {{ $dental_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="dental_status">Dental</label>
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="eye_status" id="eye_status"
                        value="1" {{ $eye_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="eye_status">Eye</label>
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="cash_counter" id="cash_counter"
                        value="1" {{ $cash_counter_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="cash_counter">Cash Counter</label>
                </div>
            </div>
        </div>
        <div class="form-row mb-2">
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="duty_area" id="duty_area" value="1"
                        {{ $duty_area_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="duty_area">Duty Area</label>
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="external_hospital" id="external_hospital"
                        value="1" {{ $external_hosp_su_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="external_hospital">External Hospital</label>
                </div>
            </div>

            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="physio_ind" id="physio_ind"
                        value="1" {{ $physio_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="physio_ind">Physiotherapy</label>
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="physio_ind" id="physio_ind"
                        value="1" {{ $physio_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="physio_ind">Clearance Department</label>
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="pos_ind" id="pos_ind" value="1"
                        {{ $pos == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="pos_ind">Point of Sale</label>
                </div>
            </div>


            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="main_ind" id="main_ind" value="1"
                        {{ $main_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="main_ind">Main Store</label>
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="sub_store_ind" id="sub_store_ind"
                        value="1" {{ $sub_store_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="sub_store_ind">Sub Store</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="asset_store" id="asset_store"
                        value="1" {{ $asset_store == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="asset_store">Asset Store</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="asset_sub_store" id="asset_sub_store"
                        value="1" {{ $asset_sub_store == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="asset_sub_store">Asset Store</label>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hr_unit_ind" id="hr_unit_ind"
                        value="1" {{ $hr_unit_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="hr_unit_ind">HR Unit</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hr_dept_ind" id="hr_dept_ind"
                        value="1" {{ $hr_dept_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="HR_DEPT_IND">HR Department</label>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hk_ind" id="hk_ind"
                        value="1" {{ $hk_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="hk_ind">Housekeeping</label>
                </div>
            </div>


        </div>


        <div class="form-row border-top">
            <div class="col-md-4 mb-2">

                <div class="form-check form-check-inline">
                    <label for="status" class="form-check-label">Status</label>
                    <input class="form-check-input ml-1" type="checkbox" name="status" id="status"
                        value="1" {{ $status == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Active</label>
                </div>
            </div>
        </div>
        <div class="modal-footer mt-1">
            <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Cancel</button>

            @php
                $response_action = route('serviceunit.index');
            @endphp
            <button class="btn btn-success btn-md"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                Save</button>
        </div>
    </form>
</div>
