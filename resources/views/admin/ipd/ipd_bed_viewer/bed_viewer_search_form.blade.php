<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<form method="post" id="bed_search_form" action="" >
    @csrf

    <div class="card mt-2">
        <div class="card-header">
            <h5> <i class="fa fa-search"></i> Search</h5>
        </div>
        <div class="card-body">
            <div class="form-row">

                <div class="col-3">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="bed">Bed</label>
                        <select class="select2" id="bed">
                            <option value="">Select Bed Name</option>
                            @foreach ($bed as $record)
                                <option value="{{ $record->bed_no_pk }}" >{{ $record->bed_name }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="ward">Ward</label>
                        <select class="select2" id="ward">
                            <option value="">select Ward Name</option>
                            @foreach ($ward as $record)
                                <option value="{{ $record->ward_no_pk }}" >{{ $record->ward_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="dept">Department</label>
                        <select class="select2" id="dept">
                            <option value="">Select Department Name</option>
                            @foreach ($service as $record)
                                <option value="{{ $record->serviceunit_no_pk }}">{{ $record->serviceunit_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="col-2">
                    <span class="btn btn-md btn-success btn-block mt-4 btn-md-global" id="bed_viewer_search" data-action="{{route("ipd/beds-viewer-list")}}" tab_type='Available' onclick="bedFunc.bedListData(this)"> <i class="fa fa-search mr-1"></i> Search</span>
{{--                    <button type="reset" class="btn btn-md btn-info mt-4" title="Click here to Clear form data" >Reset</button>--}}

                </div>
            </div>
        </div>
    </div>
</form>



<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(function() {

        $('.select2').select2();
    });


</script>

