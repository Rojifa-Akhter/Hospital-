@php

$organism = isset($organism) && !empty($organism) ? $organism : [];

$bacteria_name = $organism ? $organism->bacteria_name : '';
$bacteria_no_pk = $organism ? $organism->bacteria_no_pk : '';
$bacteria_uid = $organism ? $organism->bacteria_uid : '';
$status = $organism ? $organism->status : '';
@endphp
<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('pathology.organism-store') }}" method="post" id="organism-create">
        @csrf
        <input type="hidden" name="id" value="{{ $bacteria_no_pk }}">
        <div class="form-group row">
            <label for="organism_UID" class="col-sm-12 col-form-label col-form-label-sm">Organism UID <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="organism_UID" name="organism_UID"
                    value="{{ $bacteria_uid }}" placeholder="Enter Organism Uid" required>
            </div>

            <label for="organism_name" class="col-sm-12 col-form-label col-form-label-sm">Organism Name <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="organism_name" name="organism_name"
                    value="{{ $bacteria_name }}" placeholder="Enter organism Name" required>
            </div>
        </div>

        <div class="form-group row">

            <label for="organism_status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
            <div class="col-sm-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="organism_status" id="organism_status"
                        value="1" {{ $status == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="organism_status">Active</label>
                </div>
            </div>
        </div>


        <div class="modal-footer mt-1">
            @php
                $response_action = route('pathology.organism');
            @endphp


            <div class="col-md-12 mt-4">
                <button type="submit" class="btn btn-md btn-success"
                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
                <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>
            </div>
    </form>
</div>
