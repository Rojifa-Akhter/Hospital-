@php

// dd($ItemWiseEditdata);

$ItemWiseEditdata = isset($ItemWiseEditdata) && !empty($ItemWiseEditdata) ? $ItemWiseEditdata : [];

$default_referral_percnet = $ItemWiseEditdata ? $ItemWiseEditdata->default_referral_percnet : '';
$refpolicy_itemtype_no_pk = $ItemWiseEditdata ? $ItemWiseEditdata->refpolicy_itemtype_no_pk : '';
$default_agent_percnet = $ItemWiseEditdata ? $ItemWiseEditdata->default_agent_percnet : '';
$default_2nd_referral_percent = $ItemWiseEditdata ? $ItemWiseEditdata->default_2nd_referral_percent : '';
$item_type = $ItemWiseEditdata ? $ItemWiseEditdata->item_type : '';


//refdata
$ref_info = isset($refdata) && !empty($refdata) ? $refdata : [];
$referralpolicy_no_fk = $ref_info ? $ref_info->corporate_policy_no_pk : '';
$referralpolicy_code = $ref_info ? $ref_info->corporatepolicy_code : '';
$referralpolicy_name = $ref_info ? $ref_info->corporatepolicy_name : '';

    $commission_percent = $ItemWiseEditdata ? $ItemWiseEditdata->commission_percent : '';
    $item_type_code = $ItemWiseEditdata ? $ItemWiseEditdata->item_type : '';


// dd($referralpolicy_no_fk);
@endphp
<form method="post" action="{{ route('corporate-item-type-store') }}" id="CorporateitemWisePolicy">
    @csrf
    <input type="hidden" value="{{ $id }}" name="ref_policy_pk" id="ref_policy_pk">
    <input type="hidden" value="{{ $refpolicy_itemtype_no_pk }}" name="item_type_no_pk" id="item_type_no_pk">
    <input type="hidden" value="{{ $type }}" name="dis_type">
    <div class="container-fluid">
        @if ($type !="DISCOUNTPOLICY")
        <div class="form-group row">
            <div class="col-md-4">
                <label for="bed_uid" class="">Corporate Code</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm" id="code" name="code"
                        value="{{ $referralpolicy_code }}" placeholder="Enter Corporate Code" disabled>
                </div>
            </div>
            <div class="col-md-8">
                <label for="bed_name" class="">Corporate Policy Name </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm" id="policy_name" name="policy_name"
                        value="{{ $referralpolicy_name }}" placeholder="Enter Corporate Policy Name" disabled>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="bed_name" class="">Default Referral </label>
                <div class="row">
                    <input type="text" class="form-control form-control-sm col-md-10 ml-3" id="sec_ref" name="def_ref"
                        value="{{ $default_referral_percnet }}"><span class="text-danger">%</span>
                </div>
            </div>

            <div class="col-md-4">
                <label for="bed_name" class="">Default Agent </label>
                <div class="row">
                    <input type="text" class="form-control form-control-sm col-md-10 ml-3" id="def_agent"
                        name="def_agent" value="{{ $default_agent_percnet }}"><span class="text-danger">%</span>
                </div>
            </div>
            <div class="col-md-4">
                <label for="bed_name" class="">Default 2nd Referral </label>
                <div class="row">
                    <input type="text" class="form-control form-control-sm col-md-10 ml-3" id="sec_ref" name="sec_ref"
                        value=""><span class="text-danger">%</span>
                </div>
            </div>
        </div>
        @endif
        
        <div class="form-group row">
            <div class="col-md-6">
                <label for="bed_uid" class="">Item Type </label>
                <div class="">
                    <select class="form-control form-control-sm select2" id="item_type_name" name="item_type" value="">
                        <option value="">Select item Type</option>
                       
                        @if(isset($item_type_data) && !empty($item_type_data))                       
                            @foreach ($item_type_data as $key => $item)
                                <option value="{{$item}}">{{$item}}</option>
                            @endforeach
                        @endif                       
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label for="bed_name" class="">Comission (%) </label>
                <div class="">
                    <input type="text" class="form-control form-control-sm" id="comission" name="comission"
                        value="{{ $commission_percent }}" placeholder="Enter comission">
                </div>
            </div>
        </div>
        <div class="ml-1">
            @php
                $response_action =$type !="DISCOUNTPOLICY" ?  route('corporate.policy'): route('pcrm.discount-policy') ;
            @endphp
            <button class="btn btn-success btn-md"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                Save</button>
            <button type="button" class="btn btn-info btn-md" title="Click here to Clear form data" onclick="clearData()">Clear</button>
            <a href="" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>

        </div>
    </div>
</form>
sr