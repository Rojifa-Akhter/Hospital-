<form action="{{ route('ipd.ipd-supproting-store') }}" method="post" id="medication-create">
    @csrf
    <input type="hidden" name="chart_no_pk" value="{{ $support_data->chart_no_pk }}">

    <div class="form-group row">
        <div class="col-md-4">
            <strong for="category_lookup_no_fk" class="">Start Time : </strong>
        </div>
        <div class="col-md-8 d-flex">
            <input type="text" class="timepicker form-control" name="start_supporting_time" id="start_supporting_time">
        </div>

    </div>

    <div class="form-group row">
        <div class="col-md-4">
            <strong for="category_lookup_no_fk" class="">End Time : </strong>
        </div>
        <div class="col-md-8 d-flex">
            <input type="text" class="timepicker form-control" name="end_supporting_time" id="end_supporting_time">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-4">
            <strong for="category_lookup_no_fk" class="">Instruments : </strong>
        </div>
        <div class="col-md-8 d-flex">
            <select class="form-control form-control-sm select2 m-0 p-0"
                id="instrument_id" name="instrument_id">
                <option value="0">Select</option>
                @if (!empty($instrument_data))

                    @foreach ($instrument_data as $key=>$item)

                        <option value="{{$key}}" @if($support_data->instrument_no_fk == $key)
                            selected
                        @endif>{{$item}}</option>
                    @endforeach
                @endif

            </select>
        </div>
    </div>


    <div class="modal-footer">
        @php
            $response_action = route('ipd.ipd-supporting-form', [$admission_no, $patient_no]);
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $(".timepicker").timepicker({
            defaultTime: "",
            // interval: "5",
        });
    });

</script>
