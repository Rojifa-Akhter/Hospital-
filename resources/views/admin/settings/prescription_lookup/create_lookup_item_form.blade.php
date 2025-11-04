@php

$prescriptionlookupitem = isset($prescriptionlookupitem) && !empty($prescriptionlookupitem) ? $prescriptionlookupitem : [];

$lookupdata_no_pk = $prescriptionlookupitem ? $prescriptionlookupitem->pres_lookupdata_no_pk : '';
$lookupdata_code = $prescriptionlookupitem ? $prescriptionlookupitem->pres_lookupdata_code : '';
$lookup_no_fk = $prescriptionlookupitem ? $prescriptionlookupitem->pres_lookup_no_fk : '';
$lookup_name = $prescriptionlookupitem ? $prescriptionlookupitem->pres_lookup_name : '';
$lookupdata_name = $prescriptionlookupitem ? $prescriptionlookupitem->pres_lookupdata_name : '';
$serial_no = $prescriptionlookupitem ? $prescriptionlookupitem->serial : '';
$lookup_status = $prescriptionlookupitem ? $prescriptionlookupitem->status : '';
@endphp

<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="create_lookup_item">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-5 col-xl-12">
                <form action="{{ route('prescription-lookup.storeprescriptionlookupitem') }}" method="post"
                    id="lookupdata-create">
                    @csrf
                    <input type="hidden" name="id" value="{{ $lookupdata_no_pk }}">
                    <div class="form-group row">
                        <label for="lookup_no" class="col-sm-12 col-form-label col-form-label-sm">Lookup No <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-12">
                            <select class="form-control font_size_12 m-auto select2 required" id="lookup_no"
                                name="lookup_no" required>
                                <option selected="selected" value="">Select Lookup No</option>
                                @foreach ($prescriptionlookup_data as $record)
                                    <option value="{{ $record->pres_lookup_no_pk }}" @if ($record->pres_lookup_no_pk == $lookup_no_fk) selected @endif>{{ $record->pres_lookup_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="list_UID" class="col-sm-12 col-form-label col-form-label-sm">List UID <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control form-control-sm required" id="list_UID"
                                name="list_UID" value="{{ $lookupdata_code }}" placeholder="Enter List UID" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lookup_list_name" class="col-sm-12 col-form-label col-form-label-sm">Lookupdata Name
                            <span class="text-danger">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control form-control-sm" id="lookup_list_name"
                                name="lookup_list_name" value="{{ $lookupdata_name }}"
                                placeholder="Enter lookup List Name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lookup_serial" class="col-sm-12 col-form-label col-form-label-sm">Serial No <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control form-control-sm" id="lookup_serial"
                                name="lookup_serial" value="{{ $serial_no }}" placeholder="0" required>
                        </div>
                        <label for="" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name=" lookup_status" id="lookup_status"
                                    value="1" {{ $lookup_status == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="lookup_status">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-1">
                        @php
                            $response_action = route('prescription-lookup.indexprescriptionlookupitem');
                        @endphp
                        <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
                        <button type="submit" class="btn btn-sm btn-success"
                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(function() {
        $("#category_lookup").focus();
        $('.select2').select2();
    });

</script>
