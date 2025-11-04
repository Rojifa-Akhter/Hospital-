@php
    if(isset($item)) {
        $submitRoute = route('itemTypeWorkflow.update', [$item->workflow_no_pk]);
    } else {
        $submitRoute = route('itemTypeWorkflow.store');
    }

    $workflow_code              = $item->workflow_code ?? '';
    $workflow_name              = $item->workflow_name ?? '';
    $serviceunit_no_pk          = $item->serviceunit_no_pk ?? '';
    $service_billing_ind        = $item->service_billing_ind ?? '';
    $pharmacy_billing_ind       = $item->pharmacy_billing_ind ?? '';
    $emergency_billing_ind      = $item->emergency_billing_ind ?? '';
    $daycare_billing_ind        = $item->daycare_billing_ind ?? '';
    $ot_billing_ind             = $item->ot_billing_ind ?? '';
    $carpark_billing_ind        = $item->carpark_billing_ind ?? '';
    $cafeteria_billing_ind      = $item->cafeteria_billing_ind ?? '';
    $optical_shop_billing_ind   = $item->optical_shop_billing_ind ?? '';
    $workflow_desc              = $item->workflow_desc ?? '';
@endphp

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<form method="POST" id="frm-item-store" action="{{ $submitRoute }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        {{-- Workflow Code --}}
        <label for="workflow_code" class="col-sm-2 col-form-label col-form-label-sm">Workflow Code<span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="text" class="form-control form-control-sm" id="workflow_code" name="workflow_code"
            value="{{ $workflow_code }}" placeholder="Enter Workflow Code" required>
        </div>

        {{-- Workflow Name --}}
        <label for="workflow_name" class="col-sm-2 col-form-label col-form-label-sm">Workflow Name<span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="workflow_name" name="workflow_name" value="{{ $workflow_name }}"
            placeholder="Enter Workflow Name" required>
        </div>

        {{-- Service Point --}}
        <label for="service_point_su_no_fk" class="col-sm-2 col-form-label col-form-label-sm">Service Point <span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <select class="form-control font_size_12 m-auto select2" id="service_point_su_no_fk" name="service_point_su_no_fk" required>
                <option value="" selected disabled>Select Service Point</option>
                @if (isset($servicePoints))
                    @foreach ($servicePoints as $item)
                    <option value="{{ $item->serviceunit_no_pk }}" {{ $item->serviceunit_no_pk > 2 ? 'selected' : '' }}> {{ ucwords(strtolower($item->serviceunit_name)) }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        {{--  --}}
        <label for="" class="col-sm-2 col-form-label col-form-label-sm"></label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                {{-- <input class="form-check-input" type="checkbox" name="rate_ind" id="rate_ind" value="1"> --}}
            </div>
        </div>

        {{-- Service Billing --}}
        <label for="service_billing_ind" class="col-sm-2 col-form-label col-form-label-sm">Service Billing</label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" {{ $service_billing_ind == 1 ? 'checked' : ''}} type="checkbox" name="service_billing_ind" id="service_billing_ind" value="1">
            </div>
        </div>

        {{-- Pharmacy Billing --}}
        <label for="pharmacy_billing_ind" class="col-sm-2 col-form-label col-form-label-sm">Pharmacy Billing</label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" {{ $pharmacy_billing_ind == 1 ? 'checked' : ''}} type="checkbox" name="pharmacy_billing_ind" id="pharmacy_billing_ind" value="1">
            </div>
        </div>

        {{-- Emergency Billing --}}
        <label for="emergency_billing_ind" class="col-sm-2 col-form-label col-form-label-sm">Emergency Billing</label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" {{ $emergency_billing_ind == 1 ? 'checked' : ''}} type="checkbox" name="emergency_billing_ind" id="emergency_billing_ind" value="1">
            </div>
        </div>

        {{-- Daycare Billing --}}
        <label for="daycare_billing_ind" class="col-sm-2 col-form-label col-form-label-sm">Daycare Billing</label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" {{ $daycare_billing_ind == 1 ? 'checked' : ''}} type="checkbox" name="daycare_billing_ind" id="daycare_billing_ind" value="1">

            </div>
        </div>

        {{-- OT Billing --}}
        <label for="ot_billing_ind" class="col-sm-2 col-form-label col-form-label-sm">OT Billing</label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" {{ $ot_billing_ind == 1 ? 'checked' : ''}} type="checkbox" name="ot_billing_ind" id="ot_billing_ind" value="1">

            </div>
        </div>

        {{-- Car park Billing --}}
        <label for="carpark_billing_ind" class="col-sm-2 col-form-label col-form-label-sm">Car park Billing</label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" {{ $carpark_billing_ind == 1 ? 'checked' : ''}} type="checkbox" name="carpark_billing_ind" id="carpark_billing_ind" value="1">
            </div>
        </div>

        {{-- Cafeteria Billing --}}
        <label for="cafeteria_billing_ind" class="col-sm-2 col-form-label col-form-label-sm">Cafeteria Billing</label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" {{ $cafeteria_billing_ind == 1 ? 'checked' : ''}} type="checkbox" name="cafeteria_billing_ind" id="cafeteria_billing_ind" value="1">
            </div>
        </div>

        {{-- Optical Shop Billing --}}
        <label for="optical_shop_billing_ind" class="col-sm-2 col-form-label col-form-label-sm">Optical Shop Billing</label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" {{ $optical_shop_billing_ind == 1 ? 'checked' : ''}} type="checkbox" name="optical_shop_billing_ind" id="optical_shop_billing_ind" value="1">
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="workflow_desc" class="col-sm-2 col-form-label col-form-label-sm">Description <span class="text-danger">*</span></label>
        <div class="col-sm-12">
            <textarea class="form-control custom_area" id="workflow_desc" rows="3" name="workflow_desc" placeholder="Workflow Description" required>{{ $workflow_desc }}</textarea>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-3">
            @php
                $redirect_url = route('itemTypeWorkflow.index');
            @endphp
            {{-- <button class="btn btn-md btn-success" id="save_update" data-func="" data-response-url="{{ $response_url }}" title="Click here to save Medicine Item Information">Save</button> --}}
            {{-- <button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Close</button> --}}
            <button type="submit" class="btn btn-md btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getItemTypeWorkflow,'{{ $redirect_url }}')">Save</button>
            <button type="button" class="btn btn-md btn-danger mt-3" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-md btn-info mt-3" data-dismiss="modal">Exit</button>
        </div>
    </div>
</form>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();
</script>
