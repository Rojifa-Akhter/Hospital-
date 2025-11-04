@php
    $physicalstruct_name = $item->physicalstruct_name ?? "";
    $physicalstruct_desc = $item->physicalstruct_desc ?? "";
    $physicalstruct_building_no_pk = $item->physicalstruct_building_no_pk ?? "";
    $physicalstruct_floortype = $item->physicalstruct_floortype ?? "";

    $action = "";
    $submitText = "";
    if(isset($item)) {
        $action = route('floor.update', ['id' => $item->physicalstruct_no_pk]);
        $submitText = "Update";
    } else {
        $action = route('floor.store');
        $submitText = "Create";
    }
@endphp

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ $action }}" method="POST" id="diet-form">
    @csrf

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="physicalstruct_name" class="">Floor Name</strong>
        </div>
        <div class="col-md-12">
            <input type="text" id="physicalstruct_name" name="physicalstruct_name" value="{{ $physicalstruct_name }}" class="form-control" placeholder="Floor Name..." />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="physicalstruct_desc" class="">Floor Description</strong>
        </div>
        <div class="col-md-12">
            <input type="text" id="physicalstruct_desc" name="physicalstruct_desc" value="{{ $physicalstruct_desc }}" class="form-control" placeholder="Floor Description..." />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="physicalstruct_building_no_pk" class="">Building Name</strong>
        </div>
        <div class="col-md-12 ">
            <select name="physicalstruct_building_no_pk" id="physicalstruct_building_no_pk" class="form-control">
                <option value="">Select Building Name</option>
                @foreach($buildings as $building)
                    <option value="{{ $building->physicalstruct_build_no_pk }}" {{ $physicalstruct_building_no_pk == $building->physicalstruct_build_no_pk ? 'selected' : '' }}>{{ $building->physicalstruct_build_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="physicalstruct_floortype" class="">Floor Type</strong>
        </div>
        <div class="col-md-12">
            <input type="text" id="physicalstruct_floortype" name="physicalstruct_floortype" value="{{ $physicalstruct_floortype }}" class="form-control" placeholder="Floor Type..." />
        </div>
    </div>

    <div class="modal-footer">
        @php
            $response_action = route('floor.index');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            {{ $submitText }}</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('floor.index') }}" class="btn btn-danger btn-md" rel="tab"
            title="Click here to go back to Dashboard">Exit</a>
    </div>
</form>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
