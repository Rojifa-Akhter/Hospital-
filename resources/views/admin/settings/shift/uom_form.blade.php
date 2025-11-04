@php

    $data = isset($data) && !empty($data) ? $data : [];

    $uom_code = $data ? $data->uom_code : '';
    $uom_label_desc = $data ? $data->uom_label_desc : '';
    $uom_no_pk = $data ? $data->uom_no_pk : '';
@endphp
<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('uom-store') }}" method="post" id="UOM-create">
        @csrf
        <input type="hidden" name="id" value="{{ $uom_no_pk }}">
        <div class="form-group row">
            <label for="UOM_UID" class="col-sm-12 col-form-label col-form-label-sm">UOM UID <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="uom_code" name="uom_code"
                    value="{{ $uom_code }}" placeholder="Enter UOM uid" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="uom_label_desc" class="col-sm-12 col-form-label col-form-label-sm">Description</label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="uom_label_desc" name="uom_label_desc"
                    value="{{ $uom_label_desc }}" placeholder="Enter UOM Description">
            </div>
        </div>


        <div class="modal-footer mt-1">
            @php
                $response_action = route('uom-list');
            @endphp


            <div class="col-md-12 mt-4">
                <button type="submit"
                    class="btn btn-md btn-success"onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
                <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>
            </div>
    </form>
</div>
