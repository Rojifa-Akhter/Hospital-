@php

$ipd_date = isset($ipd_date) && !empty($ipd_date) ? $ipd_date : [];

$id = $ipd_date ? $ipd_date->ipd_medicine_inv_set_no_pk : '';
$ipd_setting_type = $ipd_date ? $ipd_date->ipd_setting_type : '';
$ipd_setting_name = $ipd_date ? $ipd_date->ipd_setting_name : '';
$type_name = $ipd_setting_type . '_' . $ipd_setting_name;
$status = $ipd_date ? $ipd_date->status : '';
// dd($refdata);
@endphp
{{-- <form method="post" action="{{ route('ipd_medicine_inv_set_store') }}" id="ipdphrPayment">
    @csrf
    <div class="container-fluid">
        <input type="hidden" value="{{ $id }}" name="hdn_ref">

        <div class="form-group row">
            <div class="col-md-6">
                <label for="code" class="col-form-label">Payment type <span>*</span></label>
                <div class="">


                        <select name="payment_type" id="payment_type" class="form-control" required>
                            <option value="">select</option>
                            <option value="1_After Pharmacy Issue" >After Pharmacy Issue</option>
                            <option value="2_After Nurse Station Receive">After Nurse Station Receive</option>

                        </select>
                </div>
            </div>
        </div>

    </div>
        <div class="form-group col-md-3">
            <div class="row ml-2 mb-2">
                <div class="check mt-1">
                    <input type="checkbox" id='active_ref' name="active" value='1'
                        {{ $status == '1' ? 'checked' : '' }}>
                </div>
                <label class="col-form-label  ml-1" for="active_ref">Active </label>
            </div>
        </div>
    </div>

    <div class="ml-3">
        @php
            $response_action = route('ipd-phr-payment-process-settings');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
    </div>
</form> --}}
<form method="post" action="{{ route('ipd_medicine_inv_set_store') }}" id="test">
    <div style="padding: 10px">
        @csrf
        <input type="hidden" value="{{ $id }}" name="id" id="id">
        <label for="code" class="col-form-label">Payment type <span class=" text-danger">*</span></label>
        <div class="">


            <select name="payment_type" id="payment_type" class="form-control" required>
                <option value="">select</option>
                <option value="1_After Pharmacy Issue">After Pharmacy Issue</option>
                <option value="2_After Nurse Station Receive">After Nurse Station Receive</option>

            </select>
        </div>
        <div class="row ml-2 mb-2">
            <div class="check mt-1">
                <input type="checkbox" id='active_ref' name="active" value='1' >
            </div>
            <label class="col-form-label  ml-1" for="active_ref">Active </label>
        </div>
        @php
            $response_action = route('ipd-phr-payment-process-settings');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save</button>

        <button type="button" onclick="resetData(this)" class="btn btn-info btn-md"
            title="Click here to Clear form data">Clear</button>
        {{-- <a href="" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a> --}}
    </div>
</form>

<script>
    function resetData(element) {
        $(element).parents('form').find('#id').val('');
        $(element).parents('form').find('#active_ref').prop('checked', false);
        $(element).parents('form').find('#payment_type').val("");
        // $(element).parents('table').find('input').val('');
        // console.log($(element).parents('form').find('#id').val());
    }

    function editData(element) {
        var id = $(element).parents("td").find('#ipd_medicine_inv_set_no_pk').val();
        var ipd_setting_type = $(element).parents("td").find('#ipd_setting_type').val();
        var ipd_setting_name = $(element).parents("td").find('#ipd_setting_name').val();
        var status = $(element).parents("td").find('#status').val();

        var type_name = ipd_setting_type + '_' + ipd_setting_name;
        console.log(type_name);
        $('#id').val(id);
        $('#payment_type option[value="' + type_name + '"]').attr("selected", "selected");
       $('#payment_type').val(type_name);
        if (status == 1) {
            $('#active_ref').prop('checked', true);
        }
    }
</script>
