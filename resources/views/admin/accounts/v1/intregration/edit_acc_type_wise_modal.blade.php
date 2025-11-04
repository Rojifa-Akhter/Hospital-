@php
$items = isset($acc_type_data) && !empty($acc_type_data) ? $acc_type_data : [];

$id = $items ? $items->integrationtrntypewise_no_pk : '';
$trn_cr_account_no_fk = $items ? $items->trn_cr_account_no_fk : '';
$trn_cr_account_percent = $items ? $items->trn_cr_account_percent : '';
$trn_dr_account_percent = $items ? $items->trn_dr_account_percent : '';
$trn_dr_account_no_fk = $items ? $items->trn_dr_account_no_fk : '';
$account_name_dr = $items ? $items->account_name_dr : '';
$account_name_cr = $items ? $items->account_name_cr : '';
$trn_type_no_fk = $items ? $items->trn_type_no_fk : '';
$trn_type_code = $items ? $items->trn_type_code : '';
$module_code = $items ? $items->module_code : '';
$module_no_fk = $items ? $items->module_no_fk : '';
$module_no_fk = $items ? $items->module_no_fk : '';
$accounts_mapping_su_no_fk = $items ? $items->accounts_mapping_su_no_fk : '';
$status = $items ? $items->status : '';
$set_patient_val_ind = $items ? $items->set_patient_val_ind : '';
$set_supplier_val_ind = $items ? $items->set_supplier_val_ind : '';
$set_person_val_ind = $items ? $items->set_person_val_ind : '';
$independent_voucher_ind = $items ? $items->independent_voucher_ind : '';

// {{ dd($serviceunit) }}

@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="">
    <form action="{{ route('accounts-integration-paymood.store') }}" method="post" id="acc_type_wise_form_data_edit">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">

        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm"> CR Account Name<span
                    class="text-danger">*</span></label>
            <div class="col-sm-6">

                <input type="text" id="itemWiseCrAccNo1" class="form-control mr-sm-2"
                    value="{{ $account_name_cr }}" placeholder="Search...">
                <input type="hidden" id="trn_cr_account_no_fk1" name="AccTypeWisecrAccNo_pk"
                    value="{{ $trn_cr_account_no_fk }}" />
                <span class="focus_input"></span>
            </div>
            <div class="col-sm-6">
                <input type="number" value="{{ $trn_cr_account_percent }}" name="AccTypeWisecrAccPar"
                    class="form-control" placeholder="%">
                <span class="focus_input"></span>
            </div>

        </div>

        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm"> DR Account Name<span
                    class="text-danger">*</span></label>
            <div class="col-sm-6">

                <input type="text" id="trn_dr_account_no1" class="form-control mr-sm-2"
                    value="{{ $account_name_dr }}" placeholder="Search...">
                <input type="hidden" id="trn_dr_account_no_fk1" name="AccTypeWisedrAccNo_pk"
                    value="{{ $trn_dr_account_no_fk }}" />
                <span class="focus_input"></span>
            </div>
            <div class="col-sm-6">
                <input type="number" name="AccTypeWisedrAccPar" value="{{ $trn_dr_account_percent }}"
                    class="form-control" placeholder="%">
                <span class="focus_input"></span>
            </div>

        </div>

        <div class="form-group row">
            <label for="AccTypeWisetrnTypeNo" class="col-sm-12 col-form-label col-form-label-sm">TRN Type
                No</label>
            <div class="col-sm-12">
                <select class="form-control select2 " id="AccTypeWisetrnTypeNo" name="AccTypeWisetrnTypeNo">
                    <option value="" selected>Select...</option>
                    @foreach ($finc_trntype as $data)
                        <option value="{{ $data->trn_type_no_pk }}_{{ $data->trn_type_code }}"
                            {{ $data->trn_type_no_pk == $trn_type_no_fk ? 'selected' : '' }}>
                            {{ $data->trn_type_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="AccTypeWisetrnTypeCode" class="col-sm-12 col-form-label col-form-label-sm">Service Unit</label>
            <div class="col-sm-12">
                <select class="form-control select2" id="AccTypeWisetrnTypeCode" name="AccTypeWiseServiceUnit">
                    <option value="" selected>Select...</option>
                    @if (!empty($service_unit))
                        @foreach ($service_unit as $data)
                            <option value="{{ $data->serviceunit_no_pk }}"
                                {{ $accounts_mapping_su_no_fk == $data->serviceunit_no_pk ? 'selected' : '' }}>
                                {{ $data->serviceunit_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>


        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Module Code <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <select class="select2 form-control" name="AccTypeWisemoduleCode" id="">
                    <option value="0_0">Select One</option>
                    @foreach ($sysc_module as $data)
                        <option {{ $data->module_no_pk == $module_no_fk ? 'selected' : '' }}
                            value="{{ $data->module_code }}">
                            {{ $data->module_name }} ({{ $data->module_code }})</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="form-group row">
            <div class="col-md-4">
                <input type="checkbox" {{ $set_patient_val_ind == 1 ? 'checked' : '' }} name="patient_ind"
                    id="patient_ind1" value="1">
                <label for="patient_ind1" class="col-form-label col-sm-10 ">Patient Ind</label>

            </div>
            <div class="col-md-4">
                <input type="checkbox" name="supplier_ind" id="supplier_ind1"
                    {{ $set_supplier_val_ind == 1 ? 'checked' : '' }} value="1">
                <label for="supplier_ind1" class="col-form-label col-sm-10 ">Supplier Ind</label>

            </div>
            <div class="col-md-4">

                <input type="checkbox" name="doctor_ind" id="doctor_ind1" value="1"
                    {{ $set_person_val_ind == 1 ? 'checked' : '' }}>
                <label for="doctor_ind1" class="col-form-label col-sm-10 ">Emp. Ind</label>

            </div>
            <div class="col-md-4">

                <input type="checkbox" name="doctor_ind" id="doctor_ind1" value="1"
                    {{ $independent_voucher_ind == 1 ? 'checked' : '' }}>
                <label for="doctor_ind1" class="col-form-label col-sm-10 ">Independent Voucher Ind</label>

            </div>



        </div>

        <div class="modal-footer float-right mt-1">
            <button type="button" class="btn  btn-md btn-danger mr-auto" data-dismiss="modal">Cancel</button>


            <button id="acc_type_wise_form_data_btn" type="submit" data-dismiss="modal"
                class="btn btn-success btn-md">
                Save</button>
        </div>
    </form>
</div>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $('.select2').select2();

    openChartOfAccountAutocomplete('#itemWiseCrAccNo1', 'account_name', '#trn_cr_account_no_fk1');
    openChartOfAccountAutocomplete('#trn_dr_account_no1', 'account_name', '#trn_dr_account_no_fk1');
</script>
