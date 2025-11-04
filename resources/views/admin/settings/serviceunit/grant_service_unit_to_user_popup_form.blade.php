@php

    $grantServiceData = (isset($grantServiceData) && (!empty($grantServiceData))) ? $grantServiceData : [];
    $grantUser_no_pk = ($grantServiceData) ? $grantServiceData->grantsu_no_pk : '';
    $grantUser_user_no_fk = ($grantServiceData) ? $grantServiceData->user_no_fk : '';
     $grantUser_su_no_fk = ($grantServiceData) ? $grantServiceData->su_no_fk : '';
    $grantUser_default_ind = ($grantServiceData) ? $grantServiceData->default_ind : '';
    $grantUser_samaple_receive_ind = ($grantServiceData) ? $grantServiceData->samaple_receive_ind : '';
    $grantUser_save_ind = ($grantServiceData) ? $grantServiceData->save_ind : '';

    $grantUser_verify_ind = ($grantServiceData) ? $grantServiceData->verify_ind : '';
    $grantUser_finalize_ind = ($grantServiceData) ? $grantServiceData->finalize_ind : '';
    $grantUser_preview_ind = ($grantServiceData) ? $grantServiceData->preview_ind : '';
    $grantUser_print_final_ind = ($grantServiceData) ? $grantServiceData->print_final_ind : '';
    $grantUser_result_edit_ind = ($grantServiceData) ? $grantServiceData->result_edit_ind : '';
    $grantUser_all_su_ind = ($grantServiceData) ? $grantServiceData->all_su_ind : '';
    $grantUser_status = ($grantServiceData) ? $grantServiceData->status : '';

    $samaple_receive_ind = ($grantServiceData) ? $grantServiceData->samaple_receive_ind : '';
    $preview_ind = ($grantServiceData) ? $grantServiceData->preview_ind : '';
    $result_edit_ind = ($grantServiceData) ? $grantServiceData->result_edit_ind : '';
    $all_su_ind = ($grantServiceData) ? $grantServiceData->all_su_ind : '';
    $hod_ind = ($grantServiceData) ? $grantServiceData->hod_ind : '';

    $labresult_list1_ind = ($grantServiceData) ? $grantServiceData->labresult_list1_ind : '';
    $labresult_list2_ind = ($grantServiceData) ? $grantServiceData->labresult_list2_ind : '';
    $labresult_list3_ind = ($grantServiceData) ? $grantServiceData->labresult_list3_ind : '';
    $labresult_list4_ind = ($grantServiceData) ? $grantServiceData->labresult_list4_ind : '';
    $labresult_list5_ind = ($grantServiceData) ? $grantServiceData->labresult_list5_ind : '';
    $hr_dept_ind = ($grantServiceData) ? $grantServiceData->hr_dept_ind : '';
    $hr_unit_ind = ($grantServiceData) ? $grantServiceData->hr_unit_ind : '';

    //dd($grantServiceData->su_name)


@endphp


<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{route('grant-service-unit-to-user-popup-form-store')}}" method="post"
          id="grant-service-form-create">
        @csrf
        <input type="hidden" name="id" value="{{$grantUser_no_pk}}">
        <div class="form-group row">
            <label for="grantuser_department" class="col-sm-12 col-form-label col-form-label-sm">Department <span
                    class="text-danger"></span></label>
            <div class="col-sm-12">
                <select name="grantuser_department" id="grantuser_department"  onchange="getDropdownListByCondition(this.value,{{route("grant-users-data")}},'#grantuser_user')"
                        class="form-control form-control-sm select2">
                    <option>Select service</option>
                    @if(!$department_data->isEmpty())
                        @foreach($department_data as $value)
                            <option
                                value="{{$value->serviceunit_no_pk}}" {{$value->serviceunit_no_pk == $grantUser_su_no_fk ? 'selected' : ''}} >
                                {{$value->serviceunit_name}}
                            </option>
                        @endforeach
                    @endif
                </select></div>

            <label for="grantuser_user" class="col-sm-12 col-form-label col-form-label-sm">User <span
                    class="text-danger"></span></label>
            <div class="col-sm-12">
                <select name="grantuser_user" id="grantuser_user" class="form-control form-control-sm select2">
                    <option value="0">Select User</option>
                    @if(!$doctor_data->isEmpty())
                        @foreach($doctor_data as $value)
                            <option
                                value="{{$value->user_no_pk}}" {{$value->user_no_pk == $grantUser_user_no_fk ? 'selected' : ''}}>
                                {{$value->user_code}}-{{$value->user_fullname}}
                            </option>
                        @endforeach
                    @endif
                </select>
                <span class="focus_input"></span>

            </div>
        </div>

        <div class="form-group form-row">
            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="grantServiceUnitDefault"
                           id="grantServiceUnitDefault" value="1" {{$grantUser_default_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="grantServiceUnitDefault">Default</label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="grantServiceUnitSave"
                           id="grantServiceUnitSave" value="1" {{$grantUser_save_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="grantServiceUnitSave">Save</label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="grantServiceUnitVerify"
                           id="grantServiceUnitVerify" value="1" {{$grantUser_verify_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="grantServiceUnitVerify">{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Check' : 'Verify'}} </label>
                </div>
            </div>


            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="grantServiceUnitFinalize"
                           id="grantServiceUnitFinalize" value="1" {{$grantUser_finalize_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="grantServiceUnitFinalize">Finalize</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="grantServiceUnitPrint"
                           id="grantServiceUnitPrint" value="1" {{$grantUser_print_final_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="grantServiceUnitPrint">Print</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="sample_receive"
                           id="sample_receive" value="1" {{$samaple_receive_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="sample_receive">Sample Receive</label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="preview"
                           id="preview" value="1" {{$preview_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="preview">Preview</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="result_edit"
                           id="result_edit" value="1" {{$result_edit_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="result_edit">Result</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="su"
                           id="Su" value="1" {{$all_su_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="Su">Service Unit</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hod_ind"
                           id="hod_ind" value="1" {{$hod_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="hod_ind">HOD Ind</label>
                </div>
            </div>




            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="prepared_by"
                           id="prepared_by" value="1" {{$labresult_list1_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="prepared_by">Prepared By</label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="verified"
                           id="verified" value="1" {{$labresult_list2_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="verified"> {{Session::get('user.ses_hospital_code')=="UNICO" ? 'Checked By' : 'Verfied By'}} </label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="finalize"
                           id="finalize" value="1" {{$labresult_list3_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="finalize">{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Approve By' : 'Finalize By'}}</label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="consult_1"
                           id="consult_1" value="1" {{$labresult_list4_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="consult_1">Consult By 1st</label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="consult_2"
                           id="consult_2" value="1" {{$labresult_list5_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="consult_2">Consult By 2nd</label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hr_dept_ind"
                           id="hr_dept_ind" value="1" {{$hr_dept_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="hr_dept_ind">HR dept.</label>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hr_unit_ind"
                           id="hr_unit_ind" value="1" {{$hr_unit_ind == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="hr_unit_ind">HR unit</label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="grantServiceUnitStatus"
                           id="grantServiceUnitStatus" value="1" {{$grantUser_status == 1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="grantServiceUnitStatus">Status</label>
                </div>
            </div>
        </div>
        <div class="modal-footer pl-0">
            @php
                $response_action = route('serviceunit.grant-service-unit-to-user');
            @endphp
            <button class="btn btn-success btn-md"
                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                Save
            </button>

            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
            <a  href="{{route('serviceunit.grant-service-unit-to-user')}}" type="reset" class="btn btn-danger btn-md"
                title="Click here to Clear form data">Exit</a>

        </div>
    </form>
</div>


<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
    // getDropdownListByCondition("#","","");
    $('.select2').select2({});
</script>
