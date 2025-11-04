@php
    $food_name = $item->food_name ?? "";

    $action = "";
    $submitText = "";
    if(isset($item)) {
        $action = route('foodType.update', ['id' => $item->food_no_pk]);
        $submitText = "Update";
    } else {
        $action = route('foodType.store');
        $submitText = "Create";
    }
@endphp

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ $action }}" method="POST" id="food-form">
    @csrf

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="food_name" class="">Food Type Name</strong>
        </div>
        <div class="col-md-12">
            <input type="text" id="food_name" name="food_name" value="{{ $food_name }}" class="form-control" placeholder="Enter Food Name..." />
        </div>
    </div>

    <div class="modal-footer">
        @php
            $response_action = route('foodType.index');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            {{ $submitText }}</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('foodType.index') }}" class="btn btn-danger btn-md" rel="tab"
            title="Click here to go back to Dashboard">Exit</a>
    </div>
</form>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
