@php

$prescriptionlookup = isset($prescriptionlookup) && !empty($prescriptionlookup) ? $prescriptionlookup : [];

$prescriptionlookup_no_pk = $prescriptionlookup ? $prescriptionlookup->pres_lookup_no_pk : '';
$prescriptionlookup_code = $prescriptionlookup ? $prescriptionlookup->pres_lookup_code : '';
$prescriptionlookup_name = $prescriptionlookup ? $prescriptionlookup->pres_lookup_name : '';
$prescriptionlookup_status = $prescriptionlookup ? $prescriptionlookup->status : '';
@endphp
<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('prescription-lookup.store') }}" method="post" id="lookup-create">
        @csrf
        <input type="hidden" name="id" value="{{ $prescriptionlookup_no_pk }}">
        <div class="form-group row">
            <label for="lookup_UID" class="col-sm-12 col-form-label col-form-label-sm">Lookup UID <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="lookup_UID" name="lookup_UID"
                    value="{{ $prescriptionlookup_code }}" placeholder="Enter lookup uid" required>
            </div>

            <label for="lookup_name" class="col-sm-12 col-form-label col-form-label-sm">Lookup Name <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="lookup_name" name="lookup_name"
                    value="{{ $prescriptionlookup_name }}" placeholder="Enter lookup Name" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="prescriptionlookup_status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
            <div class="col-sm-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name=" prescriptionlookup_status"
                        id="prescriptionlookup_status" value="1"
                        {{ $prescriptionlookup_status == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="prescriptionlookup_status">Active</label>
                </div>
            </div>
        </div>


        <div class="modal-footer mt-1">
            @php
                $response_action = route('dinamic route prevous');
            @endphp
            <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
            <button type="submit" class="btn btn-sm btn-success"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save
                changes</button>
        </div>
    </form>
</div>
