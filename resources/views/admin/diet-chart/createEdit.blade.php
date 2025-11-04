@php
    $diet_no_fk = $item->diet_no_fk ?? "";
    $food_no_fk = $item->food_no_fk ?? "";

    $action = "";
    $submitText = "";
    if(isset($item)) {
        $action = route('dietChart.update', ['id' => $item->dietfood_no_pk]);
        $submitText = "Update";
    } else {
        $action = route('dietChart.store');
        $submitText = "Create";
    }
@endphp

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ $action }}" method="POST" id="diet-chart-form">
    @csrf

    {{-- Name --}}
    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="name" class="">Diet name</strong>
        </div>
        <div class="col-md-12">
            <input type="text" name="name" class="form-control" placeholder="Enter Diet Chart Name..." />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="diet_no_fk" class="">Diet Time</strong>
        </div>
        <div class="col-md-12">
            <select name="diet_no_fk" id="diet_no_fk" class="form-control">
                <option value="">Select Diet Time</option>
                @foreach ($diets as $diet)
                    <option value="{{ $diet->diet_no_pk }}" {{ $diet_no_fk == $diet->diet_no_pk ? 'selected' : '' }}>{{ $diet->diet_name }} ({{ $diet->diet_time }})</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="food_no_fk" class="">Food Type</strong>
        </div>
        <div class="col-md-12">
            <select name="food_no_fk[]" id="food_no_fk" class="form-control select2" {{ !isset($item) ? 'multiple' : '' }}>
            </select>
        </div>
    </div>

    {{-- Price --}}
    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="price" class="">Price</strong>
        </div>
        <div class="col-md-12">
            <input type="number" min="0" name="price" class="form-control" placeholder="Enter Diet Price..." />
        </div>
    </div>

    {{-- Note --}}
    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="note" class="">Notes(If any)</strong>
        </div>
        <div class="col-md-12">
            <textarea rows="3" class="form-control" name="note"></textarea>
        </div>
    </div>

    <div class="modal-footer">
        @php
            $response_action = route('dietChart.index');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            {{ $submitText }}</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('dietChart.index') }}" class="btn btn-danger btn-md" rel="tab"
            title="Click here to go back to Dashboard">Exit</a>
    </div>
</form>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });

    $('#diet_no_fk').on('change', function(e) {
        let _value = $(this).val();

        var route = '{{ route("dietChart.getFoodsByMealType", ":id") }}';
        route = route.replace(':id', _value);

        if(_value != "") {
            $.ajax({
                data: null,
                url: route,
                type: "GET",
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    $("#food_no_fk").empty();
                    response.foods.map(food => {
                        console.log(food.food_no_fk, food.food_name);
                        console.log();
                        $("#food_no_fk").append(
                            new Option(food.food_name, food.food_no_fk),
                        );
                    });
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    });
</script>
