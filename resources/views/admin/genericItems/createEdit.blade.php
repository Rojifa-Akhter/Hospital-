@php
    $generic_name = $item->generic_name ?? "";
    $generic_description = $item->generic_description ?? "";

    $action = "";
    $submitText = "";
    if(isset($item)) {
        $action = route('genericItem.update', ['id' => $item->generic_no_pk]);
        $submitText = "Update";
    } else {
        $action = route('genericItem.store');
        $submitText = "Create";
    }
@endphp

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ $action }}" method="POST" id="generic-item-form">
    @csrf

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="generic_name" class="">Generic Item Name</strong>
        </div>
        <div class="col-md-12">
            <input type="text" id="generic_name" name="generic_name" value="{{ $generic_name }}" class="form-control" placeholder="Enter Generic Name..." required />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="generic_description" class="">Generic Description</strong>
        </div>
        <div class="col-md-12">
            <textarea class="form-control custom_area issue_description ckeditor" id="generic_description" rows="3" name="generic_description" placeholder="Enter Generic Description...">{{ $generic_description }}</textarea>
        </div>
    </div>

    <div class="modal-footer">
        @php
            $response_action = route('genericItem.index');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            {{ $submitText }}</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('genericItem.index') }}" class="btn btn-danger btn-md" rel="tab"
            title="Click here to go back to Dashboard">Exit</a>
    </div>
</form>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
