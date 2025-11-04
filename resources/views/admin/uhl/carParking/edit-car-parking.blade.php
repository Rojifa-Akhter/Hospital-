<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">


<form action="{{ route('carparking.policy-store') }}" method="post" id="car_parking_edit_id">
    @csrf
    <input type="hidden" name="id"
        value="{{ isset($carp_policy_data->ratepolicy_no_pk) ? $carp_policy_data->ratepolicy_no_pk : '' }}">
    <div class="form-group row">
        <div class="col-md-6">
            <label for="vehicle_type" class="">Vehicle Type</label>
            <div class="">
                <select class="form-control form-control-sm select2" id="vehicle_type" name="vehicle_type">
                    <option value="0">Select Type</option>
                    @if (!empty($vehicle_data))
                        @foreach ($vehicle_data as $record)
                            <option value="{{ $record->lookupdata_name }}"
                                {{ $carp_policy_data->vehicle_type == $record->lookupdata_name ? 'selected' : '' }}>
                                {{ $record->lookupdata_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <label for="vehicle_type" class="">Minimum Rate</label>
            <div class="">
                <input type="text" class="form-control form-control-sm number_only" id="minimum_rate"
                    name="minimum_rate"
                    value="{{ isset($carp_policy_data->minimum_rate) ? $carp_policy_data->minimum_rate : '' }}" />
            </div>
        </div>
        <div class="col-md-6">
            <label for="vehicle_type" class="">Minimum Hr</label>
            <div class="">
                <input type="text" class="form-control form-control-sm number_only" id="minimum_hr" name="minimum_hr"
                    value="{{ isset($carp_policy_data->minimum_hour) ? $carp_policy_data->minimum_hour : '' }}" />
            </div>
        </div>
        <div class="col-md-6">
            <label for="vehicle_type" class="">Hourly Rate</label>
            <div class="">
                <input type="text" class="form-control form-control-sm number_only" id="hourly_rate"
                    name="hourly_rate"
                    value="{{ isset($carp_policy_data->hourly_rate) ? $carp_policy_data->hourly_rate : '' }}" />
            </div>
        </div>

    </div>

    <div class="modal-footer">
        @php
            $response_action = route('v1.car-parking-policy');
        @endphp
        <button class="btn btn-success uhl_save_btn"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Update</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</form>



<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
    $('.select2').select2({});
</script>
