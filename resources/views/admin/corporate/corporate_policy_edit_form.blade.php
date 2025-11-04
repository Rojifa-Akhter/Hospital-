@php
$policy_record = isset($policy_record) && !empty($policy_record) ? $policy_record : [];
//dd($policy_record);
$corporate_policy_no_pk = $policy_record ? $policy_record->corporate_policy_no_pk : '';
$corporatepolicy_code = $policy_record ? $policy_record->corporatepolicy_code : '';
$corporatepolicy_name = $policy_record ? $policy_record->corporatepolicy_name : '';
$commission_percent = $policy_record ? $policy_record->commission_percent : '';
$commission_taka = $policy_record ? $policy_record->commission_taka : '';
$authorization_ind = $policy_record ? $policy_record->authorization_ind : '';
$authorization_code_ind = $policy_record ? $policy_record->authorization_code_ind : '';
$not_doctor_ind = $policy_record ? $policy_record->not_doctor_ind : '';
$signed_copy_ind = $policy_record ? $policy_record->signed_copy_ind : '';
$corporate_emp_id_ind = $policy_record ? $policy_record->corporate_emp_id_ind : '';
$management_sms_ind = $policy_record ? $policy_record->management_sms_ind:'';
//dd($ccm_staff_dob);
$management_email_ind = $policy_record ? $policy_record->management_email_ind : '';
$corporate_sms_ind = $policy_record ? $policy_record->corporate_sms_ind : '';
$staff_id_ind = $policy_record ? $policy_record->staff_id_ind : '';
$corporate_code_ind = $policy_record ? $policy_record->corporate_code_ind : '';
$corporate_email_ind= $policy_record ? $policy_record->corporate_email_ind: '';
$active_status_ind = $policy_record ? $policy_record->active_status_ind : '';



$applied_consult_ind = $policy_record ? $policy_record->applied_consult_ind : '';
$applied_consult_percent = $policy_record ? $policy_record->applied_consult_percent : '';
$gen_billing_ind = $policy_record ? $policy_record->gen_billing_ind : '';
$gen_billing_percent = $policy_record ? $policy_record->gen_billing_percent : '';
$applied_lab_percent = $policy_record ? $policy_record->applied_lab_percent : '';
$applied_lab_ind = $policy_record ? $policy_record->applied_lab_ind : '';
$applied_rad_ind = $policy_record ? $policy_record->applied_rad_ind : '';
$applied_rad_percent = $policy_record ? $policy_record->applied_rad_percent : '';
$applied_ipdbed_ind = $policy_record ? $policy_record->applied_ipdbed_ind : '';
$applied_ipdbed_percent = $policy_record ? $policy_record->applied_ipdbed_percent : '';
$applied_ot_ind = $policy_record ? $policy_record->applied_ot_ind : '';
$applied_ot_percent = $policy_record ? $policy_record->applied_ot_percent : '';




@endphp

        {{-- page body start--}}
       <div class="card">
            <div class="card-header "><h5> Corporate Policy</h5></div>
            <div class="card-body pt-2 pb-0">
                <form action="{{url('corporate/policy/store')}}" id="corporate2" method="post" >
                    @csrf
                    <input type="hidden" name="id" id="update_id" value="{{$corporate_policy_no_pk}}">
                    <div class="form-row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="corporateCode">Corporate Code</label>

                                <input type="text" class="form-control" name="corporateCode" value="{{$corporatepolicy_code}}" id="corporateCode" placeholder="Corporate Code">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="corporateName">Corporate Name</label>
                                <input type="text" class="form-control" name="corporateName" value="{{$corporatepolicy_name}}" id="corporateName" placeholder="Enter Corporate Name">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="max_percent">Maximum (%)</label>
                                <input type="text" class="form-control" name="max_percent" value="{{$commission_percent}}" id="max_percent" placeholder="Enter Max. percent" >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="max_value">Taka</label>
                                <input type="text" class="form-control" name="taka" value="{{$commission_taka}}" id="taka" placeholder="Enter Max. Taka" >
                            </div>
                        </div>


                        <div class="col-md-12 mt-4">
                            <div class="row ml-2">

                                <div class="form-group col-md-4">
                                    <label class="col-form-label">Consultation</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="consultation_ind"
                                                    aria-label="Checkbox for following text input" {{ $applied_consult_ind == '1' ? 'checked' : '' }}
                                                    name="consultation_ind" value='1'>
                                            </div>
                                        </div>
                                        <input type="text" name="consultation_percent"
                                            class="form-control number_only consultation_percent" value="{{$applied_consult_percent}}"
                                            id='consultation_percent' aria-label="Text input with checkbox"
                                            maxlength="3" readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="col-form-label">General Billing</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="general_billing_ind" {{ $gen_billing_ind == '1' ? 'checked' : '' }}
                                                    aria-label="Checkbox for following text input" value='1'
                                                    name="general_billing_ind">
                                            </div>
                                        </div>
                                        <input type="text" class="form-control number_only agent_ref" maxlength="3"
                                            value="{{$gen_billing_percent}}" name="general_billing" aria-label="Text input with checkbox"
                                            id="general_billing" readonly>

                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="col-form-label">OT</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="ot_ind" {{ $applied_ot_ind == '1' ? 'checked' : '' }}
                                                    aria-label="Checkbox for following text input" name="ot_ind"
                                                    value='1'>
                                            </div>
                                        </div>
                                        <input type="text" name="ot" class="form-control number_only doc_ref" value="{{$applied_ot_percent}}"
                                            id='ot' aria-label="Text input with checkbox" maxlength="3" readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-12">
                            <div class="row ml-2">
                                <div class="form-group col-md-4">
                                    <label class="col-form-label">Pathology</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="pathology_ind" {{ $applied_lab_ind == '1' ? 'checked' : '' }}
                                                    aria-label="Checkbox for following text input" value='1'
                                                    name="pathology_ind">
                                            </div>
                                        </div>
                                        <input type="text" class="form-control number_only pathology" maxlength="3"
                                            value="{{$applied_lab_percent}}" name="pathology" aria-label="Text input with checkbox" readonly>

                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-md-4">
                                    <label class="col-form-label">Radiology</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="radiology_ind" {{ $applied_rad_ind == '1' ? 'checked' : '' }}
                                                    aria-label="Checkbox for following text input" name="radiology_ind"
                                                    value='1'>
                                            </div>
                                        </div>
                                        <input type="text" name="radiology" class="form-control number_only radiology"
                                            value="{{$applied_rad_percent}}" id='radiology' aria-label="Text input with checkbox" maxlength="3"
                                            readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="col-form-label">Ipd Bed</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="ipd_bed_ind" {{ $applied_ipdbed_ind == '1' ? 'checked' : '' }}
                                                    aria-label="Checkbox for following text input" value='1'
                                                    name="ipd_bed_ind">
                                            </div>
                                        </div>
                                        <input type="text" class="form-control number_only ipd_bed" maxlength="3"
                                            value="{{$applied_ipdbed_percent}}" name="ipd_bed" aria-label="Text input with checkbox" readonly>

                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                            {{-- End --}}



                            <div class="row ml-2">
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="authorization" name="authorization"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="authorization">Authorization</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="authorization_id" name="authorization_id"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="authorization_id">Authorization
                                            Code</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="not_doctor" name="not_doctor"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="not_doctor">Not Doctor</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="signed_copy" name="signed_copy"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="signed_copy">Signed Copy</label>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-12 mt-4">
                            <div class="row ml-2">
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="authorizationedit" name="authorization" {{ $authorization_ind == '1' ? 'checked' : '' }} class="custom-control-input" >
                                        <label class="custom-control-label" for="authorizationedit">Authorization</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="authorization_idedit" name="authorization_id" {{ $authorization_code_ind == '1' ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="authorization_idedit">Authorization Code</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="not_doctoredit" name="not_doctor" {{ $not_doctor_ind == '1' ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="not_doctoredit">Not Doctor</label>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="signed_copyedit" name="signed_copyedit" {{ $signed_copy_ind == '1' ? 'checked' : '' }} class="custom-control-input" >
                                        <label class="custom-control-label" for="signed_copyedit">Signed Copy</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="row ml-2">
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="corporate_email_idedit" name="corporate_email_id" {{ $corporate_email_ind == '1' ? 'checked' : '' }} class="custom-control-input" >
                                        <label class="custom-control-label" for="corporate_email_idedit">Corporate Employee ID</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="management_smsedit" name="management_sms" {{ $management_sms_ind == '1' ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="management_smsedit">Management SMS</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="management_emailedit" name="management_email" {{ $management_email_ind == '1' ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="management_emailedit">Management Email</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="corporate_smsedit" name="corporate_sms" {{ $corporate_sms_ind == '1' ? 'checked' : '' }} class="custom-control-input" >
                                        <label class="custom-control-label" for="corporate_smsedit">Corporate SMS</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4 mb-2">
                            <div class="row ml-2">
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="staff_idedit" name="staff_id" {{ $staff_id_ind == '1' ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="staff_idedit">Staff ID</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="corporate_codeedit" name="corporate_code" {{ $corporate_code_ind == '1' ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="corporate_codeedit">Corporate Code</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="corporate_emailedit" name="corporate_email" {{ $corporate_email_ind == '1' ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="corporate_emailedit">Corporate Email</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                                        <input type="checkbox" id="activeedit" name="active" {{ $active_status_ind == '1' ? 'checked' : '' }} class="custom-control-input">
                                        <label class="custom-control-label" for="activeedit">Active</label>
                                    </div>
                                </div>


                            </div>
                        </div>

                    <div class="modal-footer">
                        @php
                        $response_action = route('corporate.policy');
                        @endphp
                        {{-- <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button> --}}
                        <button class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                    </div>
                </form>
            </div>
            </div>
        </div>






