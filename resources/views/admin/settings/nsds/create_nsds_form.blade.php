@php

$nsds = (isset($nsds) && (!empty($nsds))) ? $nsds : [];

$nsds_no_pk = ($nsds) ? $nsds->nsds_no_pk : '';
$nsds_uid = ($nsds) ? $nsds->nsds_uid : '';
$nsds_name = ($nsds) ? $nsds->nsds_name : '';
$nursestation_type = ($nsds) ? $nsds->nursestation_type : '';
$room_no_fk = ($nsds) ? $nsds->room_no_fk : '';
$sup_person_no_fk = ($nsds) ? $nsds->sup_person_no_fk : '';
$ns_ind = ($nsds) ? $nsds->ns_ind : '';
$ds_ind = ($nsds) ? $nsds->ds_ind : '';
$status = ($nsds) ? $nsds->status : '';

$su_no_fk = ($nsds) ? $nsds->su_no_fk : '';
@endphp

<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">

<div class="col-sm-12 col-lg-5 col-xl-12">

    <form action="{{ route('nsds.store-nsds') }}" method="post" id="nsds-create">
        @csrf
        <input type="hidden" name="id" value="{{ $nsds_no_pk }}">
        <div class="form-group row">
            <div class="col-md-6">
                <label for="nsds_name" class="col-sm-12 col-form-label col-form-label-sm">NSDS Name <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="nsds_name" name="nsds_name" value="{{ $nsds_name }}" placeholder="Enter NSDS Name" required>
                </div>
            </div>

            <div class="col-md-6">
                <label for="nsds_uid" class="col-sm-12 col-form-label col-form-label-sm">NSDS Code <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="nsds_uid" name="nsds_uid" value="{{ $nsds_uid }}" placeholder="Enter NSDS Code" required>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="room_no_fk" class="col-sm-12 col-form-label col-form-label-sm">Room</label>
                <div class="col-sm-12">
                    <select class="form-control font_size_12 m-auto select2" id="room_no_fk" name="room_no_fk">
                        <option selected="selected" value="">Select Room</option>
                        @if(!empty($room ))
                        @foreach ($room as $record)
                            <option value="{{ $record->room_no_pk }}" {{$record->room_no_pk == $room_no_fk ? 'selected' : ''}}>{{ $record->room_name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <label for="sup_person_no_fk" class="col-sm-12 col-form-label col-form-label-sm">User Name</label>
                <div class="col-sm-12">
                    <select class="form-control font_size_12 m-auto select2" id="sup_person_no_fk" name="sup_person_no_fk">
                        <option selected="selected" value="">Select Person</option>
                        @if(!empty($person))
                        @foreach ($person as $record)
                            <option value="{{ $record->person_no_pk }}" {{$record->person_no_pk == $sup_person_no_fk ? 'selected' : ''}}>{{ $record->full_name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 mt-1">
                <label for="nursestation_type" class="col-sm-12 col-form-label col-form-label-sm">Station Type <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <select class="form-control font_size_12 m-auto " id="nursestation_type" name="nursestation_type" required>
                        <option selected="selected" value="">Select Type</option>
                        @if(!empty($ns_types))
                        @foreach($ns_types as $key => $value )
                            <option value="{{ $key }}" @if($nursestation_type == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="col-md-6 mt-1">
                <label for="nursestation_type" class="col-sm-12 col-form-label col-form-label-sm">Department<span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <select class="form-control font_size_12 m-auto select2" id="su_no_fk" name="su_no_fk" required>
                        <option selected="selected" value="">Select Department</option>
                        @if(!empty($department))
                        @foreach($department as $key => $value )
                            <option value="{{ $value->serviceunit_no_pk }}" {{ !empty($value->serviceunit_no_pk) && $value->serviceunit_no_pk == $su_no_fk ? 'selected' : ''}}>{{ $value->serviceunit_name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="col-md-6 mt-1">
                <label for="ns_ind" class="col-sm-12 col-form-label col-form-label-sm">Choose Station For</label>
                <div class="nsds-check  col-sm-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="nsds_ind" id="ns_ind" value="1" {{ $ns_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ns_ind">Nurse Station</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="nsds_ind" id="ds_ind" value="2" {{ $ds_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ds_ind">Doctor Station</label>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <label for="status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                       <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $status == '1' ? 'checked' : '' }}>
                       <label class="form-check-label" for="status">Active</label>
                   </div>
               </div>
           </div>
       </div>

       <div class="modal-footer">
        @php
        $response_action = route('nsds.index');
        @endphp
        <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('nsds.index') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
    </div>
</form>
</div>


<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2({});

    $('.nsds-check  input[name="nsds_ind"]').on('change', function() {
        $('input[name="nsds_ind"]').not(this).prop('checked', false);
    });
</script>
