@php

// dd($data);
$anitivic = isset($data) && !empty($data) ? $data : [];


$bacteria_name = $anitivic ? $anitivic->microbiology_name : '';
$bacteria_no_pk = $anitivic ? $anitivic->microbiology_no_pk : '';
$bacteria_uid = $anitivic ? $anitivic->microbilology_uid : '';
$status = $anitivic ? $anitivic->status : '';
@endphp
<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('pathology.antivitic-store') }}" method="post" id="antivitic-create">
        @csrf
        <input type="hidden" name="id" value="{{ $bacteria_no_pk }}">
        <div class="form-group row">
            <label for="antivitic_UID" class="col-sm-12 col-form-label col-form-label-sm">Antivitic UID <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="antivitic_UID" name="antivitic_UID"
                    value="{{ $bacteria_uid }}" placeholder="Enter Antivitic Uid" required>
            </div>

            <label for="antivitic_name" class="col-sm-12 col-form-label col-form-label-sm">Antivitic Name <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="antivitic_name" name="antivitic_name"
                    value="{{ $bacteria_name }}" placeholder="Enter Antivitic Name" required>
            </div>
        </div>

        <div class="form-group row">

            <label for="antivitic_status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
            <div class="col-sm-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="antivitic_status" id="antivitic_status"
                        value="1" {{ $status == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="antivitic_status">Active</label>
                </div>
            </div>
        </div>


        <div class="modal-footer mt-1">
            @php
                $response_action = route('pathology.antivitic');
            @endphp


            <div class="col-md-12 mt-4">
                <button type="submit" class="btn btn-md btn-success"
                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
                <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>
            </div>
    </form>
</div>
