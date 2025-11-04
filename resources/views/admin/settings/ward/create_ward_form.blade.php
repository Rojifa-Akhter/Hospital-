@php

$ward = (isset($ward) && (!empty($ward))) ? $ward : [];

$ward_no_pk = ($ward) ? $ward->ward_no_pk : '';
$ward_uid = ($ward) ? $ward->ward_uid : '';
$ward_name = ($ward) ? $ward->ward_name : '';
$wardtype_lookup_no_fk = ($ward) ? $ward->wardtype_lookup_no_fk : '';
$category_lookup_no_fk = ($ward) ? $ward->category_lookup_no_fk : '';
$service_unit_no_fk = ($ward) ? $ward->service_unit_no_fk : '';
$room_no_fk = ($ward) ? $ward->room_no_fk : '';
$gender_ind = ($ward) ? $ward->gender_ind : '';
$ccu_ind = ($ward) ? $ward->ccu_ind : '';
$icu_ind = ($ward) ? $ward->icu_ind : '';
$nicu_ind = ($ward) ? $ward->nicu_ind : '';
$hdu_ind = ($ward) ? $ward->hdu_ind : '';
$emr_ind = ($ward) ? $ward->emr_ind : '';
$vip_ind = ($ward) ? $ward->vip_ind : '';
$status = ($ward) ? $ward->status : '';

@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">


    <form action="{{ route('ward.store-ward') }}" method="post" id="ward-create">
        @csrf
        <input type="hidden" name="id" value="{{ $ward_no_pk }}">
        <div class="form-group row">
            <div class="col-md-3">
                <label for="category_lookup_no_fk" class="">Ward Category <span class="text-danger">*</span></label>
                <div class="">
                    <select class="form-control font_size_12 m-auto select2" id="category_lookup_no_fk" name="category_lookup_no_fk" required>
                        <option selected="selected" value="">Select Category</option>
                        @if(!empty($category))
                        @foreach($category as $key => $value )
                            <option value="{{ $key }}" @if($category_lookup_no_fk == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <label for="service_unit_no_fk" class="">Service Unit</label>
                <div class="">
                    <select class="form-control font_size_12 m-auto select2" id="service_unit_no_fk" name="service_unit_no_fk">
                        <option selected="selected" value="">Select Service Unit</option>
                        @if($service_unit)
                            @foreach ($service_unit as $record)
                                <option value="{{ $record->serviceunit_no_pk }}" {{$record->serviceunit_no_pk == $service_unit_no_fk ? 'selected' : ''}}>{{ $record->serviceunit_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <label for="room_no_fk" class="">Ward Room</label>
                <div class="">
                    <select class="form-control font_size_12 m-auto select2" id="room_no_fk" name="room_no_fk">
                        <option selected="selected" value="">Select Room</option>
                        @if($room)
                            @foreach ($room as $record)
                                <option value="{{ $record->room_no_pk }}" {{$record->room_no_pk == $room_no_fk ? 'selected' : ''}}>{{ $record->room_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-3 mt-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="ward_ind" id="ccu_ind" value="1" {{ $ccu_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="ccu_ind">CCU</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="ward_ind" id="icu_ind" value="2" {{ $icu_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="icu_ind">ICU</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="ward_ind" id="nicu_ind" value="3" {{ $nicu_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="nicu_ind">NICU</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-3">
                <label for="ward_uid" class="">Ward Code <span class="text-danger">*</span></label>
                <div class="">
                    <input type="text" class="form-control form-control-sm" id="ward_uid" name="ward_uid" value="{{ $ward_uid }}" placeholder="Enter Ward Code" required>
                </div>
            </div>
            <div class="col-md-3">
                <label for="ward_name" class="">Ward Name <span class="text-danger">*</span></label>
                <div class="">
                    <input type="text" class="form-control form-control-sm" id="ward_name" name="ward_name" value="{{ $ward_name }}" placeholder="Enter Ward Name" required>
                </div>
            </div>
            <div class="col-md-3">
                <label for="wardtype_lookup_no_fk" class="">Ward Type <span class="text-danger">*</span></label>
                <div class="">
                    <select class="form-control font_size_12 m-auto select2" id="wardtype_lookup_no_fk" name="wardtype_lookup_no_fk" required>
                        <option selected="selected" value="">Select Type</option>
                        @if(!empty($ward_types))
                            @foreach($ward_types as $key => $value )
                                <option value="{{ $key }}" @if($wardtype_lookup_no_fk == $key) selected @endif>{{ $value }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="col-md-3 mt-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="ward_ind" id="hdu_ind" value="4" {{ $hdu_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="hdu_ind">HDU</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="ward_ind" id="vip_ind" value="5" {{ $vip_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="vip_ind">VIP</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="ward_ind" id="emr_ind" value="6" {{ $emr_ind == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="emr_ind">Emergency</label>
                </div>
            </div>
        </div>



        <div class="form-group row">
            <div class="col-md-3">
                <label for="status" class="">Status</label>
                <div class="">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $status == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>
       </div>

       <div class="modal-footer">
        @php
        $response_action = route('ward.index');
        @endphp
        <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('ward.index') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
    </div>
</form>



<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
    $('.select2').select2({});
    $('.ward-check input[name="ward_ind"]').on('change', function() {
        $('input[name="ward_ind"]').not(this).prop('checked', false);
    });
</script>
