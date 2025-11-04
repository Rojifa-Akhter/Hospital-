{{-- <div id="referral_policy_form" style="width:100% !important;"> --}}
{{-- @include('admin.pcrm.referral.referral_policy_popup') --}}

{{-- </div> --}}


@php

$disdata = isset($data) && !empty($data) ? $data : [];

$discountpolicy_no_pk = $disdata ? $disdata->discountpolicy_no_pk : '';
$dispolicy_code = $disdata ? $disdata->dispolicy_code : '';
$discount_name = $disdata ? $disdata->discount_name : '';
$maximum_percent = $disdata ? $disdata->maximum_percent : '';
$maximum_amount = $disdata ? $disdata->maximum_amount : '';
$req_authorization_ind = $disdata ? $disdata->req_authorization_ind : '';
$req_authorization_code_ind = $disdata ? $disdata->req_authorization_code_ind : '';
$req_doctor_ind = $disdata ? $disdata->req_doctor_ind : '';
$req_signed_copy_ind = $disdata ? $disdata->req_signed_copy_ind : '';
$req_staff_id_ind = $disdata ? $disdata->req_staff_id_ind : '';
$req_corporate_code_ind = $disdata ? $disdata->req_corporate_code_ind : '';
$req_corporate_employee_id_ind = $disdata ? $disdata->req_corporate_employee_id_ind : '';
$applied_others_ind = $disdata ? $disdata->applied_others_ind : '';
$applied_considerdtl_ind = $disdata ? $disdata->applied_considerdtl_ind : '';
$applied_ot_ind = $disdata ? $disdata->applied_ot_ind : '';
$applied_ipdbed_ind = $disdata ? $disdata->applied_ipdbed_ind : '';
$applied_rad_ind = $disdata ? $disdata->applied_rad_ind : '';
$applied_lab_ind = $disdata ? $disdata->applied_lab_ind : '';
$gen_billing_ind = $disdata ? $disdata->gen_billing_ind : '';
$req_corporate_email_ind = $disdata ? $disdata->req_corporate_email_ind : '';
$req_corporate_sms_ind = $disdata ? $disdata->req_corporate_sms_ind : '';
$req_management_sms_ind = $disdata ? $disdata->req_management_sms_ind : '';
$req_staff_id_ind = $disdata ? $disdata->req_staff_id_ind : '';
$req_corporate_code_ind = $disdata ? $disdata->req_corporate_code_ind : '';
$req_corporate_email_ind = $disdata ? $disdata->req_corporate_email_ind : '';
$item_level_disc_ind = $disdata ? $disdata->item_level_disc_ind : '';
$status = $disdata ? $disdata->status : '';

$applied_consult_ind = $disdata ? $disdata->applied_consult_ind : '';
$gen_billing_ind = $disdata ? $disdata->gen_billing_ind : '';
$applied_lab_ind = $disdata ? $disdata->applied_lab_ind : '';
$applied_rad_ind = $disdata ? $disdata->applied_rad_ind : '';
$applied_ipdbed_ind = $disdata ? $disdata->applied_ipdbed_ind : '';
$applied_ot_ind = $disdata ? $disdata->applied_ot_ind : '';
$applied_consult_percent = $disdata ? $disdata->applied_consult_percent : '';
$gen_billing_percent = $disdata ? $disdata->gen_billing_percent : '';
$applied_lab_percent = $disdata ? $disdata->applied_lab_percent : '';
$applied_rad_percent = $disdata ? $disdata->applied_rad_percent : '';
$applied_ipdbed_percent = $disdata ? $disdata->applied_ipdbed_percent : '';
$applied_ot_percent = $disdata ? $disdata->applied_ot_percent : '';
// dd($refdata);
@endphp


<form action="{{ route('pcrm.discount-policy-save') }}" id="searchForm" method="post">
    <input type="hidden" name="id" id="update_id" value="{{ $discountpolicy_no_pk }}">
    <div class="form-row">
        <div class="col-sm-2">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="code">Code</label>

                <input type="text" class="form-control" name="code" id="code" placeholder="Discount Code"
                    value="{{ $dispolicy_code }}">
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="discount_name">Discount
                    Name</label>
                <input type="text" class="form-control" name="discount_name" id="discount_name"
                    placeholder="Enter Discount Name" value="{{ $discount_name }}">
            </div>
        </div>
















        <div class="col-sm-2">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="max_percent">Maximum (%)</label>
                <input type="text" class="form-control" name="max_percent" id="max_percent"
                    placeholder="Enter Max. percent" value="{{ $maximum_percent }}">
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="max_value">Taka</label>
                <input type="text" class="form-control" name="max_value" id="max_value" placeholder="Enter Max. Taka"
                    value="{{ $maximum_amount }}">
            </div>
        </div>



        <div class="form-group col-md-2">
            <label class="col-form-label">Consultation</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" id="consultation_ind" aria-label="Checkbox for following text input"
                            name="consultation_ind" value='1' {{ $applied_consult_ind == '1' ? 'checked' : '' }}>
                    </div>
                </div>
                <input type="text" name="consultation_percent" class="form-control number_only consultation_percent"
                    value="{{ $applied_consult_percent }}" id='consultation_percent' aria-label="Text input with checkbox"
                    maxlength="3" disabled>
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span>%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-md-2">
            <label class="col-form-label">General Billing</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" id="general_billing_ind" aria-label="Checkbox for following text input" value='1'
                             name="general_billing_ind"{{ $gen_billing_ind == '1' ? 'checked' : '' }}>
                    </div>
                </div>
                <input type="text" class="form-control number_only agent_ref" maxlength="3"
                    value="{{ $gen_billing_percent }}" name="general_billing" aria-label="Text input with checkbox" id="general_billing" disabled>

                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span>%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-md-2">
            <label class="col-form-label">OT</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" id="ot_ind" aria-label="Checkbox for following text input"
                            name="ot_ind" value='1'{{ $applied_ot_ind == '1' ? 'checked' : '' }}>
                    </div>
                </div>
                <input type="text" name="ot" class="form-control number_only doc_ref"
                    value="{{ $applied_ot_percent }}" id='ot' aria-label="Text input with checkbox"
                    maxlength="3" disabled>
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span>%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-md-2">
            <label class="col-form-label">Pathology</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" id="pathology_ind" aria-label="Checkbox for following text input" value='1'
                             name="pathology_ind"{{ $applied_lab_ind == '1' ? 'checked' : '' }}>
                    </div>
                </div>
                <input type="text" class="form-control number_only pathology" maxlength="3"
                    value="{{ $applied_lab_percent }}" name="pathology" aria-label="Text input with checkbox" disabled>

                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span>%</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group col-md-2">
            <label class="col-form-label">Radiology</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" id="radiology_ind" aria-label="Checkbox for following text input"
                            name="radiology_ind" value='1'{{ $applied_rad_ind == '1' ? 'checked' : '' }}>
                    </div>
                </div>
                <input type="text" name="radiology" class="form-control number_only radiology"
                    value="{{ $applied_rad_percent }}" id='radiology' aria-label="Text input with checkbox"
                    maxlength="3" disabled>
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span>%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-md-2">
            <label class="col-form-label">Ipd Bed</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" id="ipd_bed_ind" aria-label="Checkbox for following text input" value='1'
                             name="ipd_bed_ind" {{ $applied_ipdbed_ind == '1' ? 'checked' : '' }}>
                    </div>
                </div>
                <input type="text" class="form-control number_only ipd_bed" maxlength="3"
                    value="{{ $applied_ipdbed_percent }}" name="ipd_bed" aria-label="Text input with checkbox" disabled>

                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span>%</span>
                    </div>
                </div>
            </div>
        </div>




        <div class="col-md-12 mt-4">
            <div class="row ml-2">
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="authorization" name="authorization"
                            class="custom-control-input" {{ $req_authorization_ind == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="authorization">Authorization</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="authorization_id" name="authorization_id"
                            class="custom-control-input" {{ $req_authorization_code_ind == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="authorization_id">Authorization
                            Code</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="not_doctor" name="not_doctor" class="custom-control-input"
                            {{ $req_doctor_ind == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="not_doctor">Not Doctor</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="signed_copy" name="signed_copy"
                            class="custom-control-input" {{ $req_signed_copy_ind == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="signed_copy">Signed Copy</label>
                    </div>
                </div>
                {{--  --}}
            </div>
        </div>

        <div class="col-md-12 mt-4">
            <div class="row ml-2">
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="corporate_email_id" name="corporate_email_id"
                            class="custom-control-input" {{ $req_signed_copy_ind == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="corporate_email_id">Corporate Employee
                            ID</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="management_sms" name="management_sms"
                            class="custom-control-input" {{ $req_corporate_sms_ind == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="management_sms">Management SMS</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="management_email" name="management_email"
                            class="custom-control-input" {{ $req_management_sms_ind == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="management_email">Management
                            Email</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="corporate_sms" name="corporate_sms"
                            class="custom-control-input" {{ $req_signed_copy_ind == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="corporate_sms">Corporate SMS</label>
                    </div>
                </div>
                {{-- <div class="col-md-2">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="corporate_email" name="corporate_email" class="custom-control-input">
                        <label class="custom-control-label" for="corporate_email">Corporate Email</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="active" name="active" class="custom-control-input">
                        <label class="custom-control-label" for="active">Active</label>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="col-md-12 mt-4 mb-2">
            <div class="row ml-2">
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="staff_id" name="staff_id" class="custom-control-input"
                            {{ $req_signed_copy_ind == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="staff_id">Staff ID</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="corporate_code" name="corporate_code"
                            class="custom-control-input" {{ $req_corporate_code_ind == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="corporate_code">Corporate Code</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="corporate_email" name="corporate_email"
                            class="custom-control-input" {{ $req_corporate_email_ind == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="corporate_email">Corporate
                            Email</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="item_level_ind" name="item_level_ind"
                            class="custom-control-input" {{ $item_level_disc_ind == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="item_level_ind">Item Level Discount</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox custom-control-inline text-center">
                        <input type="checkbox" value='1' id="active" name="active" class="custom-control-input"
                            {{ $status == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="active">Active</label>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="modal-footer">
        @php
            $response_action = route('pcrm.discount-policy');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('bed.index') }}" class="btn btn-danger btn-md" rel="tab"
            title="Click here to go back to Dashboard">Exit</a>
    </div>
</form>
