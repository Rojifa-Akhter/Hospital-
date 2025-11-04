@php
$items = isset($paymode_item) && !empty($paymode_item) ? $paymode_item : [];

$id = $items ? $items->integrationpaymood_no_pk : '';
$payment_mood = $items ? $items->payment_mood : '';
$bank_no_fk = $items ? $items->bank_no_fk : '';
$card_type = $items ? $items->card_type : '';
$trn_cr_account_no_fk = $items ? $items->trn_cr_account_no_fk : '';
$trn_cr_account_percent = $items ? $items->trn_cr_account_percent : '';
$trn_dr_account_percent = $items ? $items->trn_dr_account_percent : '';
$trn_dr_account_no_fk = $items ? $items->trn_dr_account_no_fk : '';
$account_name_dr = $items ? $items->account_name_dr : '';
$account_name_cr = $items ? $items->account_name_cr : '';
$module_code = $items ? $items->module_code : '';
$module_no_fk = $items ? $items->module_no_fk : '';
$voucher_type_no_fk = $items ? $items->voucher_type_no_fk : '';
$status = $items ? $items->status : '';

// {{ dd($serviceunit) }}

@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="">
    <form action="{{ route('accounts-integration-paymood.store') }}" method="post"
        id="accounts-integration-paymood-edit">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Pay Mood <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <select class="select2 form-control" name="payment_mood" id="" required>
                    <option value="">Select One</option>
                    @if (!empty($paymodes))
                        @foreach ($paymodes as $key => $data)
                            <option value="{{ $data }}" {{ $payment_mood == $data ? 'selected' : '' }}>
                                {{ $data }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

        </div>
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Bank Name </label>
            <div class="col-sm-12">
                <select class="select2 form-control" name="bank_no_fk" id="">
                    <option value="">Select One</option>
                    @if (!empty($bank_name))
                        @foreach ($bank_name as $key => $data)
                            <option value="{{ $key }}" {{ $bank_no_fk == $key ? 'selected' : '' }}>
                                {{ $data }}</option>
                        @endforeach
                    @endif

                </select>
            </div>

        </div>
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Card Type</label>
            <div class="col-sm-12">
                <select class="select2 form-control" name="card_type" id="">
                    <option value="">Select One</option>
                    <option {{ $card_type == 'City Maxx' ? 'selected' : '' }} value="City Maxx">City Maxx</option>
                    <option {{ $card_type == 'visa' ? 'selected' : '' }} value="visa">Visa</option>
                    <option {{ $card_type == 'master' ? 'selected' : '' }} value="master">Master</option>
                    <option {{ $card_type == 'bKash' ? 'selected' : '' }} value="bKash">bKash
                    </option>
                    <option {{ $card_type == 'nogod' ? 'selected' : '' }} value="nogod">Nogod
                    </option>
                    <option {{ $card_type == 'rocket' ? 'selected' : '' }} value="rocket">Rocket
                    </option>
                </select>
            </div>

        </div>
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Trans CR Account <span
                    class="text-danger">*</span></label>
            <div class="col-sm-6">

                <input type="text" id="itemWiseCrAccNo1" class="form-control mr-sm-2" value="{{ $account_name_cr }}"
                    placeholder="Search...">
                <input type="hidden" id="trn_cr_account_no_fk1" name="trn_cr_account_no_fk"
                    value="{{ $trn_cr_account_no_fk }}" />
                <span class="focus_input"></span>
            </div>
            <div class="col-sm-6">
                <input type="number" value="{{ $trn_cr_account_percent }}" name="trn_cr_account_percent"
                    class="form-control" placeholder="%">
                <span class="focus_input"></span>
            </div>

        </div>

        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Trans DR Account <span
                    class="text-danger">*</span></label>
            <div class="col-sm-6">

                <input type="text" id="trn_dr_account_no1" class="form-control mr-sm-2"
                    value="{{ $account_name_dr }}" placeholder="Search...">
                <input type="hidden" id="trn_dr_account_no_fk1" name="trn_dr_account_no_fk"
                    value="{{ $trn_dr_account_no_fk }}" />
                <span class="focus_input"></span>
            </div>
            <div class="col-sm-6">
                <input type="number" name="trn_dr_account_percent" value="{{ $trn_dr_account_percent }}"
                    class="form-control" placeholder="%">
                <span class="focus_input"></span>
            </div>

        </div>
        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Module Code <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <select class="select2 form-control" name="module_no_fk" id="">
                    <option value="0_0">Select One</option>
                    @foreach ($sysc_module as $data)
                        <option {{ $data->module_no_pk == $module_no_fk ? 'selected' : '' }}
                            value="{{ $data->module_no_pk }}_{{ $data->module_code }}">
                            {{ $data->module_name }} ({{ $data->module_code }})</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="form-group row">
            <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Voucher Type </label>
            <div class="col-sm-12">
                <select class="select2 form-control" name="voucher_type_no_fk" id="">
                    <option value="0">Select One</option>
                    @if (!empty($voucher_type))
                        @foreach ($voucher_type as $type)
                            <option {{ $type->voucher_type_no_pk == $voucher_type_no_fk ? 'selected' : '' }}
                                value="{{ $type->voucher_type_no_pk }}">
                                {{ $type->voucher_type_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

        </div>
        <div class="form-group row">
            <div class="col-md-4 mb-2">

                <div class="form-check form-check-inline">
                    <input class="form-check-input ml-1" type="checkbox" name="status" id="status" value="1"
                        {{ $status == '1' ? 'checked' : '' }}>
                    <label for="status" class="form-check-label">Status</label>

                </div>
            </div>
        </div>



        <div class="modal-footer float-right mt-1">
            <button type="button" class="btn  btn-md btn-danger mr-auto" data-dismiss="modal">Cancel</button>

            @php
                $response_action = route('accounts-integration-paymood.index');
            @endphp
            <button class="btn btn-success btn-md"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
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
