@php

$bank_data = isset($bank_service_data) && !empty($bank_service_data) ? $bank_service_data : [];

$bank_charge_no_pk = $bank_data ? $bank_data->bank_charge_no_pk : '';
$bank_charge_code = $bank_data ? $bank_data->bank_charge_code : '';
$card_type_data = $bank_data ? $bank_data->card_type : '';
$lookup_no_fk = $bank_data ? $bank_data->lookup_no_fk : '';
$service_charge_percent = $bank_data ? $bank_data->service_charge_percent : '';
$bank_no_fk = $bank_data ? $bank_data->bank_no_fk : '';
@endphp

<div class="card">
    <form action="{{ route('service-charge-store') }}" method="post" id="bed-charge-edit">
        @csrf
        <input type="hidden" name="id" value="{{ $bank_charge_no_pk }}">
        <div class="card-body p-2">
            <div class="form-row justify-content-center">
                <div class="form-group col-md-4 m-0 focused">
                    <label for="bank_code" class="col-form-label s-12">Bank Code & Name</label>
                    <div class="input-group">
                        <div class="input-group-prepend w-100">
                            <input type="text" class="form-control form-control-sm required" id="bank_code"
                                name="bank_code" value="{{ $bank_charge_code }}" placeholder="Code"
                                style="width: 100px;">
                            <select class="form-group form-control keep_me" id="bank_name" name="bank_name" required="">
                                <option value="">select Bank Name</option>
                                @if (!empty($bank))
                                    @foreach ($bank as $pk => $bank)
                                        <option value="{{ $pk }}" {{ $pk == $bank_no_fk ? 'selected' : '' }}>
                                            {{ $bank }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="card_type" class="col-form-label col-form-label-sm">Card Type</label>
                        <select class="form-group form-control keep_me" id="card_type" name="card_type" required="">
                            <option value="">select Bank Name</option>
                            @if (!empty($card_type))
                                @foreach ($card_type as $pk => $card_type)
                                    <option value="{{ $pk }}" {{ $pk == $card_type_data ? 'selected' : '' }}>
                                        {{ $card_type }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="service_charge" class="col-form-label col-form-label-sm">Service Charge</label>
                        <input type="text" class="form-control form-control-sm text-right number_only"
                            id="service_charge" name="service_charge" value="{{ $service_charge_percent }}"
                            placeholder="0.00">
                    </div>
                </div>
                <div class="col-md-1">

                    @php
                        $response_action = route('bank-service-charge-list');
                    @endphp
                    <button class="btn btn-md btn-success mt-4"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                        Save</button>

                </div>



            </div>
        </div>
    </form>
</div>
