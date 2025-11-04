<style>
    .discharge_note .redactor_.redactor_editor {
        height: 100px !important;
    }
</style>

<?php
$pre_ot_date = $admission_details->pre_ot_date ? date('d-m-Y',strtotime($admission_details->pre_ot_date)) : '' ;
$pre_ot_time = $admission_details->pre_ot_time ? date('h:i a',strtotime($admission_details->pre_ot_time)) : '' ;
$post_ot_date = $admission_details->post_ot_date ? date('d-m-Y',strtotime($admission_details->post_ot_date)) : '' ;
$post_ot_time = $admission_details->post_ot_time ? date('h:i a',strtotime($admission_details->post_ot_time)) : '' ;
$first_baby_birthdate = $admission_details->first_baby_birthdate ? date('d-m-Y',strtotime($admission_details->first_baby_birthdate)) : '' ;
$first_baby_time = $admission_details->first_baby_time ? date('h:i a',strtotime($admission_details->first_baby_time)) : '' ;
$second_baby_birthdate = $admission_details->second_baby_birthdate ? date('d-m-Y',strtotime($admission_details->second_baby_birthdate)) : '' ;
$second_baby_time = $admission_details->second_baby_time ? date('h:i a',strtotime($admission_details->second_baby_time)) : '' ;
?>
<div class="" id="summary_data">
<div class="card">
    <div class="card-body">
        <div class="form-row border-bottom mt-3 pb-3">
            <div class="col-md-12">
                <table class="table border-0 m-0">
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
                                <input class='hdn_investigation_id' id='hdn_investigation_id_1' type='hidden' name='hdn_investigation_id[]' value=''>
                                <input class='hdn_item_name' type='hidden' name='hdn_investigation_name[]' id='hdn_investigation_name_1' value=''>
                                <input class='hdn_item_type' type='hidden' id='hdn_investigation_type_1' name='hdn_investigation_type[]' value=''>

                                <input type="text" class="form-control item_investigation_typehead form-control-sm m-0" id="investigation_1" name="investigation[]" value="" placeholder="Enter Investigation Name">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control form-control-sm m-0" id="investigation_findings_1" name="investigation_findings[]" value="" placeholder="Write Investigation Findings">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control form-control-sm m-0" id="investigation_note_1" name="investigation_note[]" value="" placeholder="Write Investigation Note">
                            </td>
                            <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_fin_td_action_1">
                                <span class="btn btn-success btn-sm" onclick="addRowForInvestigation(this)"> <i class="fa fa-plus"></i> </span>
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
                                <input class='hdn_investigation_id' id='hdn_investigation_id_{{ $key }}' type='hidden' name='hdn_investigation_id[]' value='{{ $row->item_no_fk }}'>
                                <input class='hdn_item_name' type='hidden' name='hdn_investigation_name[]' id='hdn_investigation_name_{{ $key }}' value='{{ $row->investigation_name }}'>
                                <input class='hdn_item_type' type='hidden' id='hdn_investigation_type_{{ $key }}' name='hdn_investigation_type[]' value=''>

                                <input type="text" class="form-control item_investigation_typehead form-control-sm m-0" id="investigation_{{ $key }}" name="investigation[]" value="{{ $row->investigation_name }}" placeholder="Enter Investigation Name">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control form-control-sm m-0" id="investigation_findings_{{ $key }}" name="investigation_findings[]" value="{{ $row->findings_text }}" placeholder="Write Investigation Findings">
                            </td>
                            <td class="p-0 px-1 border-0">
                                <input type="text" class="form-control form-control-sm m-0" id="investigation_note_{{ $key }}" name="investigation_note[]" value="{{ $row->investigation_note }}" placeholder="Write Investigation Note">
                            </td>
                            <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_fin_td_action_{{ $key }}">
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
                </table>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-12">
                <table class="table border-0 m-0">
                    <thead>
                        <tr class="border-0">
                            <th class="p-0 px-1 border-0 w-25">Generic / Brand</th>
                            <th class="p-0 px-1 border-0">Dose</th>
                            <th class="p-0 px-1 border-0">Duration</th>
                            <th class="p-0 px-1 border-0">Quantity</th>
                            <th class="p-0 px-1 border-0">Instruction</th>
                            <th class="p-0 px-1 border-0">Continue</th>
                            <th class="p-0 px-1 border-0"></th>
                        </tr>
                    </thead>
                    <tbody id="data-append-to">
                        <tr class="border-0" id="1">
                            <td class="p-0 px-1 border-0">
                                <input class='item_id' id='hdn_item_id_1' type='hidden' name='hdn_item_id[]' value=''>
                                <input class='hdn_item_name' type='hidden' id='hdn_item_name_1' name='hdn_item_name[]' value=''>
                                <input class='hdn_item_type' type='hidden' id='hdn_item_type_1' name='hdn_item_type[]' value=''>

                                <input type="text" class="form-control item_typehead form-control-sm m-0 p-0 item_element" id="medicine_item_1" name="medicine_item[]" placeholder="Generic / Brand">
                            </td>

                            <td class="p-0 px-1 border-0">
                                <select class="form-control form-control-sm select2 m-0 p-0 medicine_dose" id="medicine_dose_1" name="medicine_dose[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose');prescriptionFunc.calculateMedicineQnty(this);">
                                    <option value="0">Select</option>
                                    @if (!empty($dose))
                                    @foreach ($dose as $key => $value)
                                    <option data-qnty="" value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </td>

                            <td class="p-0 px-1 border-0 w-20">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm m-0 p-0 medicine_duration" id="medicine_duration_type_1" name="medicine_duration_type[]" onkeyup="prescriptionFunc.calculateMedicineQnty(this)">
                                    <select class="form-control medicine_duration_mu" id="medicine_duration_mu_1" name="medicine_duration_mu[]" onchange="prescriptionFunc.calculateMedicineQnty(this)">
                                        <option value="0">Select</option>
                                        @if (!empty($followup_mu))
                                        @foreach ($followup_mu as $key => $value)

                                        @if (strtoupper($value) == 'DAY')
                                        <option value="{{ strtoupper($value) }}" selected="selected">
                                            {{ $value }}
                                        </option>
                                        @else
                                        <option value="{{ strtoupper($value) }}">{{ $value }}</option>
                                        @endif

                                        @endforeach
                                        @endif

                                    </select>
                                </div>
                            </td>

                            <td class="p-0 px-1 border-0 w-10">
                                <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity" id="medicine_quantity_1" name="medicine_quantity[]">
                            </td>

                            <td class="p-0 px-1 border-0">
                                <select class="form-control form-control-sm select2 m-0 p-0" id="instruction_1" name="instruction[]">
                                    <option value="0">Select</option>
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
                                <span class="btn btn-success btn-sm" onclick="addRow(this)"> <i class="fa fa-plus"></i> </span>
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
                                <input class='item_id' id='hdn_item_id_{{ $counter }}' type='hidden' name='hdn_item_id[]' value='{{ $row->item_no_fk }}'>
                                <input class='hdn_item_name' type='hidden' id='hdn_item_name_{{ $counter }}' name='hdn_item_name[]' value='{{ $row->item_name }}'>
                                <input class='hdn_item_type' type='hidden' id='hdn_item_type_{{ $counter }}' name='hdn_item_type[]' value=''>

                                <input type="text" class="form-control item_typehead form-control-sm m-0 p-0 item_element" id="medicine_item_{{ $counter }}" name="medicine_item[]" value="{{ $row->item_name }}" placeholder="Generic / Brand">
                            </td>

                            <td class="p-0 px-1 border-0">
                                <select class="form-control form-control-sm select2 m-0 p-0 medicine_dose" id="medicine_dose_{{ $counter }}" name="medicine_dose[]">
                                    <option value="0">Select</option>
                                    @if (!empty($dose))
                                    @foreach ($dose as $key => $value)
                                    <option value="{{ $value }}" {{ $value == $row->dosage ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </td>

                            <td class="p-0 px-1 border-0 w-20">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm m-0 p-0 medicine_duration" id="medicine_duration_type_{{ $counter }}" name="medicine_duration_type[]" value="{{ $row->duration }}">
                                    <select class="form-control medicine_duration_mu" id="medicine_duration_mu_{{ $counter }}" name="medicine_duration_mu[]">
                                        <option value="0">Select</option>
                                        @if (!empty($followup_mu))
                                        @foreach ($followup_mu as $key => $value)
                                        <option value="{{ strtoupper($value) }}" {{ strtoupper($value) == $row->duration_mu ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                        @endforeach
                                        @endif

                                    </select>
                                </div>
                            </td>

                            <td class="p-0 px-1 border-0 w-10">
                                <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity" id="medicine_quantity_{{ $counter }}" name="medicine_quantity[]" value=" {{$row->item_qty ? $row->item_qty : ''}}">
                            </td>

                            <td class="p-0 px-1 border-0">
                                <select class="form-control form-control-sm select2 m-0 p-0" id="instruction_{{ $counter }}" name="instruction[]">
                                    <option value="0">Select</option>
                                    @if (!empty($instructions))
                                    @foreach ($instructions as $key => $value)
                                    <option value="{{ $key }}" {{ $key == $row->med_taken_instruction ? 'selected' : '' }}>{{ $value }}
                                    </option>
                                    @endforeach
                                    @endif

                                </select>
                            </td>

                            <td class="p-0 px-1 border-0">
                                <input type="checkbox" id="is_continue_{{ $counter }}" value="1" name="is_continue_{{$row->item_no_fk}}[]" {{ $row->continue_ind == 1 ? 'checked' : '' }}>
                            </td>

                            <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_td_action_{{ $counter }}">
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
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Discharge Note</h5>
            </div>
            <div class="card-body p-2 discharge_note">
                <textarea id="discharge_note" name="discharge_note">{{ $admission_details->discharge_summary_note }}</textarea>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">

                <h5>Advice</h5>
            </div>
            <div class="card-body p-2">
                <textarea id="advice" name="advice"> {{ $admission_details->discharge_advice }}</textarea>
            </div>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">

                <h5>Pre-OT Note</h5>
            </div>
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Pre ot date</label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker" name="pre_ot_date" placeholder="dd-mm-yy" value="{{$pre_ot_date}}">

                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Pre ot Time</label>
                        <input type="text" class="form-control form-control-sm m-0 timepicker" name="pre_ot_time" placeholder="time" value="{{$pre_ot_time}}">

                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Pre ot operation</label>
                        <input type="text" class="form-control form-control-sm m-0" name="pre_ot_operation" placeholder="" value="{{$admission_details->pre_ot_operation}}">
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Pre ot indication</label>
                        <input type="text" class="form-control form-control-sm m-0" name="pre_ot_indication" placeholder="" value="{{$admission_details->pre_ot_indication}}">
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Pre ot anaesthesia</label>
                        <input type="text" class="form-control form-control-sm m-0" name="" placeholder="" id="pre_ot_anaesthesia" value="{{$pre_ot_anaesthesia_no}}">
                        <input type="hidden" name="pre_ot_anaesthesia" id="hdn_pre_ot_anaesthesia"  value="{{$admission_details->pre_ot_anaesthesia_no}}">
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Pre ot surgeon</label>
                        <input type="text" class="form-control form-control-sm m-0" name="" placeholder="" id="pre_ot_surgeon" value="{{$pre_ot_surgeon_no}}">
                        <input type="hidden" name="pre_ot_surgeon" id="hdn_pre_ot_surgeon"  value="{{$admission_details->pre_ot_surgeon_no}}">
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Pre ot anaesthetist</label>
                        <input type="text" class="form-control form-control-sm m-0" id="pre_ot_anaesthetist" placeholder="" value="{{$pre_ot_anaesthetist_no}}">
                        <input type="hidden" name="pre_ot_anaesthetist" id="hdn_pre_ot_anaesthetist"  value="{{$admission_details->pre_ot_anaesthetist_no}}">
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Pre ot precedure</label>
                        <input type="text" class="form-control form-control-sm m-0" name="pre_ot_precedure" placeholder=""  value="{{$admission_details->pre_ot_precedure}}">
                    </div>
                </div>
                <textarea id="pre_ot" name="pre_ot">{{ $admission_details->pre_ot_note }}</textarea>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">

                <h5>Post-OT Note</h5>
            </div>
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Post ot date</label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker" name="post_ot_date" placeholder="dd-mm-yy" value="{{$post_ot_date}}">

                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Post ot Time</label>
                        <input type="text" class="form-control form-control-sm m-0 timepicker" name="post_ot_time" placeholder="time" value="{{$post_ot_time}}">

                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Post ot operation</label>
                        <input type="text" class="form-control form-control-sm m-0" name="post_ot_operation" placeholder="" value="{{$admission_details->post_ot_operation}}">
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Post ot indication</label>
                        <input type="text" class="form-control form-control-sm m-0" name="post_ot_indication" placeholder="" value="{{$admission_details->post_ot_indication}}">
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Post ot anaesthesia</label>
                        <input type="text" class="form-control form-control-sm m-0" id="post_ot_anaesthesia" placeholder="" value="{{$post_ot_anaesthesia_no}}">
                        <input type="hidden" name="post_ot_anaesthesia" id="hdn_post_ot_anaesthesia" value="{{$admission_details->post_ot_anaesthesia_no}}">
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Post ot surgeon</label>
                        <input type="text" class="form-control form-control-sm m-0" id="post_ot_surgeon" placeholder="" value="{{$post_ot_surgeon_no}}">
                        <input type="hidden" name="post_ot_surgeon" id="hdn_post_ot_surgeon" value="{{$admission_details->post_ot_surgeon_no}}">
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Post ot anaesthetist</label>
                        <input type="text" class="form-control form-control-sm m-0" id="post_ot_anaesthetist" placeholder="" value="{{$post_ot_anaesthetist_no}}">
                        <input type="hidden" name="post_ot_anaesthetist" id="hdn_post_ot_anaesthetist" value="{{$admission_details->post_ot_anaesthetist_no}}">
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">Post ot precedure</label>
                        <input type="text" class="form-control form-control-sm m-0" name="post_ot_precedure" placeholder="" value="{{$admission_details->post_ot_precedure}}">
                    </div>
                </div>
                <textarea id="post_ot" name="post_ot">{{ $admission_details->post_ot_note }}</textarea>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5> 1st Baby Note </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">1st baby birthDate</label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker" name="first_baby_birth_date" placeholder="dd-mm-yy" value="{{$first_baby_birthdate}}">

                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">1st baby Time</label>

                        <input type="text" class="form-control form-control-sm m-0 timepicker" name="first_baby_time" placeholder="time" value="{{$first_baby_time}}">

                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">1st baby Gender</label>
                        <select class="form-control form-control-sm select2 m-0 p-0" id="" name="first_baby_gender">
                            <option value="">Select</option>
                            @if (!empty($gender))
                            @foreach ($gender as $key => $value)
                            <option value="{{ $key }}"  @if ( $key == $admission_details->first_baby_gender_no) selected @endif > {{ $value }}</option>
                            @endforeach
                            @endif

                        </select>

                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">1st baby Wt</label>
                        <input type="text" class="form-control form-control-sm m-0" name="first_baby_wt" placeholder="" value="{{$admission_details->first_baby_wt}}">
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">1st baby A/s</label>
                        <input type="text" class="form-control form-control-sm m-0" name="first_baby_as" placeholder="" value="{{$admission_details->first_baby_as}}">
                    </div>
                </div>
                <textarea id="first_baby_note" name="first_baby_note">{{ $admission_details->first_baby_note }}</textarea>
            </div>

        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5> 2nd Baby Note </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">2nd baby birthDate</label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker" name="second_baby_birth_date" placeholder="dd-mm-yy" value="{{$second_baby_birthdate}}">

                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">2nd baby Time</label>

                        <input type="text" class="form-control form-control-sm m-0 timepicker" name="second_baby_time" placeholder="time" value="{{$second_baby_time}}">

                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">2nd baby Gender</label>
                        <select class="form-control form-control-sm select2 m-0 p-0" id="" name="second_baby_gender">
                            <option value="">Select</option>
                            @if (!empty($gender))
                            @foreach ($gender as $key => $value)
                            <option value="{{ $key }}"  @if ( $key == $admission_details->second_baby_gender_no) selected @endif>{{ $value }}</option>
                            @endforeach
                            @endif

                        </select>

                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">2nd baby Wt</label>
                        <input type="text" class="form-control form-control-sm m-0" name="second_baby_wt" placeholder="" value="{{$admission_details->second_baby_wt}}">
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label col-form-label-sm">2nd baby A/s</label>
                        <input type="text" class="form-control form-control-sm m-0" name="second_baby_as" placeholder="" value="{{$admission_details->second_baby_as}}">
                    </div>
                </div>
                <textarea id="second_baby_note" name="second_baby_note">{{ $admission_details->second_baby_note }}</textarea>
            </div>

        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Case Summary </h5>
            </div>
            <div class="row ml-1 mr-1">
                <div class="col-md-4">
                    <label for="" class="col-form-label col-form-label-sm">CC</label>
                    <input type="text" class="form-control form-control-sm m-0" name="cc" placeholder="" value="{{$admission_details->cc_text}}">
                </div>
                <div class="col-md-4">
                    <label for="" class="col-form-label col-form-label-sm">O/E ON ADMISSION</label>
                    <input type="text" class="form-control form-control-sm m-0" name="on_admission" placeholder="" value="{{$admission_details->oe_admission}}">
                </div>
                <div class="col-md-4">
                    <label for="" class="col-form-label col-form-label-sm">O/E ON DISCHARGE</label>
                    <input type="text" class="form-control form-control-sm m-0" name="on_discharge" placeholder="" value="{{$admission_details->oe_discharge}}">
                </div>

            </div>

        </div>
    </div>
</div>
</div>

