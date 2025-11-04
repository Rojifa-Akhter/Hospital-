@php
    $diet_name = $item->diet_name ?? "";
    $diet_time = $item->diet_time ?? "";

    $action = "";
    $submitText = "";
    if(isset($item)) {
        $action = route('dietType.update', ['id' => $item->diet_no_pk]);
        $submitText = "Update";
    } else {
        $action = route('dietType.store');
        $submitText = "Create";
    }
@endphp

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ $action }}" method="POST" id="diet-form">
    @csrf

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="diet_name" class="">Diet Type Name</strong>
        </div>
        <div class="col-md-12">
            <input type="text" id="diet_name" name="diet_name" value="{{ $diet_name }}" class="form-control" placeholder="Enter Diet Name..." />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="diet_time" class="">Diet Time Name</strong>
        </div>
        <div class="col-md-12">
            <input type="time" id="diet_time" name="diet_time" value="{{ $diet_time }}" class="form-control" placeholder="Enter Diet Time..." />
        </div>
    </div>

    <div class="modal-footer">
        @php
            $response_action = route('dietType.index');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            {{ $submitText }}</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('dietType.index') }}" class="btn btn-danger btn-md" rel="tab"
            title="Click here to go back to Dashboard">Exit</a>
    </div>
</form>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
