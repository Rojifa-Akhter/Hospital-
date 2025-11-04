@php
$uom = (isset($uom) && !empty($uom)) ? $uom : [];
$id = ($uom) ? $uom->uom_no_pk : '';
$uom_code = ($uom) ? $uom->uom_code : '';
// $uom_label_desc = ($uom) ? $uom->uom_label_desc : ''; 
$status = ($uom) ? $uom->status : '';
@endphp

<form method="post" id="frm-uom-store" action="{{ route('v1.store.save-uom') }}">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}">

    <div class="form-group row">
        <label for="uom_code" class="col-sm-4 col-form-label col-form-label-sm">UOM Name <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="uom_code" name="uom_code" value="{{ $uom_code }}" placeholder="Enter UOM Name" required>
        </div>
    </div>
    {{-- <div class="form-group row">
        <label for="uom_label_desc" class="col-sm-4 col-form-label col-form-label-sm">Serial No <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" id="uom_label_desc" name="uom_label_desc" value="{{ $uom_label_desc }}" placeholder="Enter Serial No" required>
        </div>
    </div> --}}

    <div class="form-group row">
        <label for="status" class="col-sm-4 col-form-label col-form-label-sm">UOM Status</label>
        <div class="col-sm-8">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $status == '1' ? 'checked' : '' }}>
                <label class="form-check-label" for="status">Active</label>
            </div>
        </div>
    </div>

    

    @php
    $response_action = route('v1.store.uom-setup');
    @endphp

    <div class="modal-footer mt-1">
        
    <button type="button" class="btn btn-sm btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save changes</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-danger">close</button>
        
        <a href="{{route('v1.store.uom-setup')}}" class="btn btn-sm btn-info ">Exit</a>
    </div>
</form>
