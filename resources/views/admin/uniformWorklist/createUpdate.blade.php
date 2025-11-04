@php
    $uniform_ind_status = '';
    $shoe_ind_status = '';
    $winteruniform_ind_status = '';
    $activeStatus = 'checked';
    $inactiveStatus = '';

    if(isset($item)) {
        $submitRoute = route('uniform.update', [$item->uniformpolicy_no_pk]);

        if($item->uniform_ind == 1) {
            $uniform_ind_status = 'checked';
        }

        if($item->shoe_ind == 1) {
            $shoe_ind_status = 'checked';
        }

        if($item->winteruniform_ind == 1) {
            $winteruniform_ind_status = 'checked';
        }

        if($item->status == '1') {
            $activeStatus = 'checked';
            $inactiveStatus = '0';
        } else {
            $activeStatus = '0';
            $inactiveStatus = 'checked';
        }
    } else {
        $submitRoute = route('uniform.store');
    }

    $serviceunit_no_fk  = $item->serviceunit_no_fk ?? '';
    $designation_no_fk  = $item->designation_no_fk ?? '';
    // $uniform_ind        = $item->uniform_ind ?? '';
    // $shoe_ind           = $item->shoe_ind ?? '';
    // $winteruniform_ind  = $item->winteruniform_ind ?? '';
    // $status             = $item->status ?? '';
@endphp

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<form method="POST" id="form-uniform-store-{{ rand() }}" action="{{ $submitRoute }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        {{-- Department --}}
        {{-- <label for="serviceunit_no_fk" class="col-sm-2 col-form-label col-form-label-sm">Department <span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <select class="form-control font_size_12 m-auto select2" id="serviceunit_no_fk" name="serviceunit_no_fk" required>
                <option value="" selected disabled>Select Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->serviceunit_no_pk }}" {{ $serviceunit_no_fk == $department->serviceunit_no_pk ? 'selected' : '' }}> {{ ucwords(strtolower($department->serviceunit_name)) }}</option>
                @endforeach
            </select>
        </div> --}}

        {{-- Designation --}}
        <label for="designation_no_fk" class="col-sm-2 col-form-label col-form-label-sm">Designation <span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <select class="form-control font_size_12 m-auto select2" id="designation_no_fk" name="designation_no_fk" required>
                <option value="" selected disabled>Select Designation</option>
                @foreach ($designations as $designation)
                    <option value="{{ $designation->designation_no_pk }}" {{ $designation_no_fk == $designation->designation_no_pk ? 'selected' : '' }}> {{ ucwords(strtolower($designation->designation_name)) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        {{-- Uniform --}}
        <label for="uniform_ind" class="col-sm-2 col-form-label col-form-label-sm">Uniform</label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="uniform_ind" id="uniform_ind" value="1" {{ $uniform_ind_status }} />
            </div>
        </div>

        {{-- Shoes --}}
        <label for="shoe_ind" class="col-sm-2 col-form-label col-form-label-sm">Shoes</label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="shoe_ind" id="shoe_ind" value="1" {{ $shoe_ind_status }} />
            </div>
        </div>

        {{-- Winter Uniform --}}
        <label for="winteruniform_ind" class="col-sm-2 col-form-label col-form-label-sm">Winter Uniform</label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="winteruniform_ind" id="winteruniform_ind" value="1" {{ $winteruniform_ind_status }} />
            </div>
        </div>

        {{-- Status --}}
        <label for="status" class="col-sm-2 col-form-label col-form-label-sm">Status</label>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <div class="listRadio">
            <input type="radio" class="moduleRadio" name="status" id="active" {{ $activeStatus }} value="1">
            <label for="active">Active </label>
        </div>
        &nbsp;&nbsp;
        <div class="listRadio">
            <input type="radio" class="moduleRadio" name="status" id="inactive" {{ $inactiveStatus }} value="0">
            <label for="inactive">Inactive </label>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-3">
            @php
                $redirect_url = route('uniform.index');
            @endphp
            <button type="submit" class="btn btn-md btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getUniformSetupData,'{{ $redirect_url }}')">Save</button>
            <button type="button" class="btn btn-md btn-danger mt-3" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-md btn-info mt-3" data-dismiss="modal">Exit</button>
        </div>
    </div>
</form>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();
</script>
